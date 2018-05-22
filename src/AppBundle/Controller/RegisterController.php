<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use LinkedIn\LinkedIn;

use Bundles\UserBundle\Entity\Info;
use Bundles\StoreBundle\Entity\Country;
use Bundles\StoreBundle\Entity\Community;
use Bundles\OptionBundle\Entity\Category;
use Bundles\OptionBundle\Entity\InterestedIn;
use Bundles\OptionBundle\Entity\Industry;
use Bundles\OptionBundle\Entity\Zone;
use Bundles\OptionBundle\Entity\AuthorType;

class RegisterController extends Controller
{

    /**
     * @Route("/register", name="register")
     */
    public function indexAction(Request $request)
    {
        /** @var $userManager UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        if ($request->isMethod('POST')) {
            if ($request->get('user-email')) {
                if ($userManager->findUserByEmail($request->get('user-email'))) {
                    $this->addFlash(
                        'registratior_error',
                        "The email address you entered is already in use."
                    );
                    return $this->render('AppBundle:Register:registration.html.twig', [
                        'city' => $request->get('user-city'),
                        'email' => $request->get('user-email'),
                    ]);
                } else {
                    $this->get('session')->set('fos_user_email', $request->get('user-email'));
                    $this->get('session')->set('fos_user_city', $request->get('user-city'));
                }
            }
        }
        return $this->redirectToRoute('registration_network');
    }

    /**
     * @Route("/register/confirm/{token}", name="registration_2")
     */
    public function confirmAction(Request $request, $token)
    {

        $userManager = $this->get('fos_user.user_manager');

        $user = $userManager->findUserByConfirmationToken($token);

        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with confirmation token "%s" does not exist', $token));
        }
        $user->addRole('ROLE_MEMBER');

        $user->setEnabled(true);
        $user->setConfirmationToken(null);

        $userManager->updateUser($user);

        $loginManager = $this->get('fos_user.security.login_manager');
        $loginManager->loginUser('main', $user);

        $this->addFlash('registration_success', 'Welcome to the Death Star, have a magical day!');

        return $this->redirectToRoute('profile');
    }

    /**
     * @Route("/register/step-2", name="registration_network")
     */
    public function networkAction(Request $request)
    {
        $countries = $this->getDoctrine()->getRepository(Country::class)->findAll();
        $city = $this->get('session')->get('fos_user_city');
        return $this->render('AppBundle:Register:network.html.twig', array(
            'countries' => $countries,
            'city' => $city
        ));
    }

    /**
     * @Route("/register/save-communities", name="register_save_communities")
     */
    public function saveCommunitiesAction(Request $request)
    {
        $data = $request->get('communities');

        $em = $this->getDoctrine()->getManager();
        $nm = $this->get('notification_manager');

        /** @var $userManager UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->createUser();
        $user->setEnabled(true);
        $user->setCity($this->get('session')->get('fos_user_city'));
        $user->setEmail($this->get('session')->get('fos_user_email'));
        $user->setEnabled(true);
        $user->setPlainPassword(uniqid());
        $userManager->updateUser($user);
        $loginManager = $this->get('fos_user.security.login_manager');
        $loginManager->loginUser('main', $user);

        if ($data) {
            foreach ($data as $comId) {
                $comm = $em->find(Community::class, $comId);
                // if (!$user->getCommunities()->contains($comm)) {
                    $user->addCommunity($comm);
                    $nm->joinToCommunity($user, $comm);
                // }
            }
        }

        $userManager = $this->get('fos_user.user_manager');
        $userManager->updateUser($user);

        return  new RedirectResponse($this->generateUrl('register_3'));
    }

    /**
     * @Route("/registration/linkedin", name="register_linkedin")
     */
    public function linkedinAction(Request $request)
    {
        $user = $this->getUser();

        if (!$user) {
            return new RedirectResponse('/');
        }

        $params = [];
        if ($request->get('code')) {
            $li = new LinkedIn(
                array(
                  'api_key' => '77kbf67mm814tp',
                  'api_secret' => 'zaOsdLxyHQbH7j5g',
                  'callback_url' => $this->generateUrl('register_linkedin', [], 0)
                )
            );

            $token = $li->getAccessToken($request->get('code'));
            $info = $li->get('/people/~:(first-name,last-name,picture-urls::(original))');

            if (isset($info['pictureUrls']) && $info['pictureUrls']['_total']) {
            $im = $this->get('bundles.image_manager');
            $im->setImageGlobal($user, $info['pictureUrls']['values'][0]);
            }

            $params["firstName"] = $info["firstName"];
            $params["lastName"] = $info["lastName"];

        }

        return $this->redirectToRoute('register_3', $params);
    }


    /**
     * @Route("/registration/step-3", name="register_3")
     */
    public function profileAction(Request $request)
    {
        $user = $this->getUser();

        if (!$user) {
            return new RedirectResponse('/');
        }
//        $info = [];
//        if ($request->get('code')) {
//            $li = new LinkedIn(
//                array(
//                  'api_key' => '77kbf67mm814tp',
//                  'api_secret' => 'zaOsdLxyHQbH7j5g',
//                  'callback_url' => $this->generateUrl('register_linkedin', [], 0)
//                )
//            );
//
//            $token = $li->getAccessToken($request->get('code'));
//            $info = $li->get('/people/~:(first-name,last-name,picture-urls::(original))');
//
//            if (isset($info['pictureUrl'])) {
//            $im = $this->get('bundles.image_manager');
//            $im->setImageGlobal($user, $info['pictureUrl']);
//            }
//
//        }

        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository(Category::class)->findAll();
        $interests = $em->getRepository(InterestedIn::class)->findAll();
        $industries = $em->getRepository(Industry::class)->findAll();
        $zones = $em->getRepository(Zone::class)->findAll();
        $types = $em->getRepository(AuthorType::class)->findAll();

        $res = compact('categories', 'interests', 'industries', 'zones', 'types');
        if ($request->isMethod('POST')) {
            $error = false;

             if ($request->get('first-name') &&
                $request->get('last-name') &&
                $request->get('password') &&
                $request->get('password2')) {

                $userManager = $this->get('fos_user.user_manager');

                if ($request->get('password') == $request->get('password2')) {
                    $user->setPlainPassword($request->get('password'));
                } else {
                    $this->addFlash('registration_profile_error', 'Passwords do not match !');
                    $error = true;
                }

                $firstname = ucfirst(strtolower($request->get('first-name')));
                $lastname = ucfirst(strtolower($request->get('last-name')));

                $user->setFirstName($firstname);
                $user->setLastName($lastname);
                $user->setJob($request->get('job'));
                $user->setIndustry($em->find(Industry::class, $request->get('industry')))
                    ->setCategory($em->find(Category::class, $request->get('category')))
                    ->setZone($em->find(Zone::class, $request->get('zone')));
                        //->setType($em->find(AuthorType::class, $request->get('type')));
                $user->setConfirmationToken(null);

                $info = new Info;
                $info->setEmail($user->getEmail());
                $user->setInform($info);
                $em->persist($info);

                if ($request->get('interested-in')) {
                    foreach ($request->get('interested-in') as $value) {
                        $user->addInterestedIn($em->find(InterestedIn::class, $value));
                    }
                }

                if ($error) {
                    return $this->render('AppBundle:Register:profile.html.twig', $res);
                }

                if (null === $user->getConfirmationToken()) {
                    $user->setConfirmationToken($this->get('fos_user.util.token_generator')->generateToken());
                }

                //save user data
                $userManager->updateUser($user);

                //send email
                $message = \Swift_Message::newInstance()
                    ->setSubject('Bienvenue dans Manavao')
                    ->setFrom('no-reply@manavao.com')
                    ->setTo($user->getEmail())
                    ->setBody(
                        $this->renderView('AppBundle:Register:email.html.twig', compact('user')),
                        'text/html'
                    )
                ;
                $this->get('mailer')->send($message);

                $this->get('session')->set('fos_user_send_confirmation_email/email', $user->getEmail());

                return $this->redirectToRoute('profile');
            }
        }
        return $this->render('AppBundle:Register:profile.html.twig', $res);
    }

    /**
     * @Route("/registration/profile/avatar-change", name="register_avatar_change")
     */
    public function avatarAction(Request $request)
    {
        $user = $this->getUser();

        if (!$user) {
            return new RedirectResponse('/');
        }

        if ($request->files->get('your-avatar')) {
            $im = $this->get('bundles.image_manager');
            $im->setImage($user, $request->files->get('your-avatar'));
        }

        return new JsonResponse(['image' => $user->getImage()->getSrc() ]);

        return $this->redirectToRoute('register_3');
    }

    /**
     * @Route("/registration/final", name="register_final")
     */
    public function finalAction(Request $request)
    {
        return $this->render('AppBundle:Register:final.html.twig', []);
    }

    /**
     * @Route("/remove/{email}", name="temp_user_remove")
     */
    public function userRemoveAction($email, Request $request)
    {
        $userManager = $this->get('fos_user.user_manager');

        $user = $userManager->findUserByEmail($email);

        if (!$user) {
            return new \Symfony\Component\HttpFoundation\Response("user $email not found!");
        }

        $em = $this->getDoctrine()->getManager();

        $em->remove($user);
        $em->flush();

        return new \Symfony\Component\HttpFoundation\Response("user $email removed!");
    }

    /**
     * @Route("/ajax-send-confirmation-email", name="ajax_send_confirmation_email")
     */
    public function sendConfirmationEmailAction(Request $request)
    {
        $user = $this->getUser();

        if (!filter_var($request->get('userEmail'), FILTER_VALIDATE_EMAIL)) {
            return new JsonResponse(['error' => true]);
        }

        $userManager = $this->get('fos_user.user_manager');

        if (null === $user->getConfirmationToken()) {
            $user->setConfirmationToken($this->get('fos_user.util.token_generator')->generateToken());
            $userManager->updateUser($user);
        }

        //send email
        $message = \Swift_Message::newInstance()
            ->setSubject('Bienvenue dans Manavao')
            ->setFrom('no-reply@manavao.com')
            ->setTo($user->getEmail())
            ->setBody(
                $this->renderView('AppBundle:Register:email.html.twig', compact('user')),
                'text/html'
            )
        ;

        $this->get('mailer')->send($message);

        return new JsonResponse(['error' => false]);
    }

}

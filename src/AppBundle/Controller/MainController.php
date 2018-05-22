<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpFoundation\Response;

use Bundles\StoreBundle\Entity\Community;
use Bundles\StoreBundle\Entity\UrbanArea;
use Bundles\StoreBundle\Entity\Post;
use Bundles\UserBundle\Entity\User;


class MainController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $community = null;
        $c = $request->get('c');
        // Get the community from the "c" name
        if ($c) {
            $community = $this->getDoctrine()->getRepository(Community::class)->getByName($c);
        }

        $communities = $this->getDoctrine()->getRepository(Community::class)->getEnabled();

        if ($this->isGranted('ROLE_MEMBER')) {
            return $this->redirectToRoute('profile');
        }
        $csrfToken = $this->has('security.csrf.token_manager')
            ? $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue()
            : null;

        $googleApi = $this->container->getParameter('google_api');
        return $this->render('AppBundle:Main:index.html.twig', [
                'google_api' => $googleApi,
                'csrfToken' => $csrfToken,
                'c' => $c,
                'communities' => $communities,
                'count_communities' => count($communities),
                'community' => $community
            ]);
    }

    /**
     * @Route("/public-community/{area}", name="public-community")
     */
    public function publicCommunityAction(UrbanArea $area)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $comm = $em->getRepository(Community::class)->findOneBy(['area' => $area]);
        $post = $em->getRepository(Post::class)->getCommunityPost($comm);
        $lastUsers = $em->getRepository(User::class)->getLastUsersInComm($comm, 6);
        $nearly = $em->getRepository(Community::class)->getNearlyForCommunity($comm, 6);

        $csrfToken = $this->has('security.csrf.token_manager')
            ? $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue()
            : null;

        return $this->render('AppBundle:Main:publicCommunity.html.twig', compact('post', 'lastUsers', 'comm', 'nearly', 'csrfToken'));
    }

    /**
     * @Route("/about-us", name="about_us")
     */
    public function contentPageLayoutAction(Request $request)
    {
        return $this->render('AppBundle:Main:contentPageLayout.html.twig', []);
    }

    /**
     * @Route("/privacy", name="privacy")
     */
    public function privacyPageAction()
    {
        return $this->render('AppBundle:Main:privacyPage.html.twig');
    }

    /**
     * @Route("/terms", name="terms")
     */
    public function termsPageAction()
    {
        return $this->render('AppBundle:Main:termsPage.html.twig');
    }

    /**
     * @Route("/investors", name="investors")
     */
    public function investorsPageAction()
    {
        return $this->render('AppBundle:Main:investorsPage.html.twig');
    }

    /**
     * @Route("/jobs", name="jobs")
     */
    public function jobsPageAction()
    {
        return $this->render('AppBundle:Main:jobsPage.html.twig');
    }

    /**
     * @Route("/partners", name="partners")
     */
    public function partnersPageAction()
    {
        return $this->render('AppBundle:Main:partnersPage.html.twig');
    }

    /**
     * @Route("/legal-reference", name="legal_reference")
     */
    public function legalReferencePageAction()
    {
        return $this->render('AppBundle:Main:legalReferencePage.html.twig');
    }

    /**
     * @Route("/get-ip-ajax/", name="get-ip-ajax")
     */
    public function getIpAjaxAction()
    {
        $locationFinder = $this->get('bundles_user.location_finder');
        $viewData = $locationFinder->getCoordinatesByIp();
        $encoders = array(new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($viewData, 'json');
        $response = new Response($jsonContent);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}

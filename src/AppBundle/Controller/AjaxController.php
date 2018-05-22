<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Bundles\StoreBundle\Entity\Country;
use Bundles\StoreBundle\Entity\UrbanArea;
use Bundles\StoreBundle\Entity\City;
use Bundles\StoreBundle\Entity\Community;
use Bundles\UserBundle\Entity\User;
use Bundles\StoreBundle\Entity\Post;
use Bundles\StoreBundle\Entity\SharePost;
use Bundles\StoreBundle\Entity\LikePost;
use Bundles\StoreBundle\Entity\Comment;
use Bundles\StoreBundle\Entity\Notification;
use Bundles\OptionBundle\Entity\InterestedIn;

class AjaxController extends Controller
{    
    /**
     * @Route("/ajax-get-urban-areas/{countryId}", name="ajax-get-urban-areas")
     */
    public function getUrbanAreasAction($countryId)
    {
        $areas = $this->getDoctrine()->getRepository(UrbanArea::class)->getArray($countryId);
        
        return new JsonResponse($areas);
    }
    
    /**
     * @Route("/ajax-get-cities/{areaId}", name="ajax-get-cities")
     */
    public function getCitiesAction($areaId)
    {
        $cities = $this->getDoctrine()->getRepository(City::class)->getArray($areaId);
        
        return new JsonResponse($cities);
    }
    
    /**
     * @Route("/ajax-get-communities-by-area/{area}", name="ajax-get-communities-by-area")
     */
    public function getCommunitiesAction($area)
    {
        $data = $this->getDoctrine()->getRepository(Community::class)->getNearlyByArea($area);
        
        return new JsonResponse($data);
    }
    
    /**
     * @Route("/delete-comm/{comm}", name="delete-comm")
     */
    public function deleteCommAction(Community $comm)
    {
        $user = $this->getUser();
        $user->removeCommunity($comm);
        $this->getDoctrine()->getManager()->flush();
        return new JsonResponse();
    }
    
    /**
     * @Route("/add-comm/{comm}", name="add-comm")
     */
    public function addCommAction(Community $comm)
    {
        $user = $this->getUser();
        
        if ($user->getCommunities()->contains($comm)) {
            return new JsonResponse([]);
        }
        
        $user->addCommunity($comm);
        $nm = $this->get('notification_manager');
        $nm->joinToCommunity($user, $comm);
        
//        $this->getDoctrine()->getManager()->flush();
        return new JsonResponse(array('commId' => $comm->getId(), 
            'commName' => $comm->getName(), 
            'country' => $comm->getArea()->getCountry()->getName()));
    }
    
    /**
     * @Route("/profile/delete-interest/{interestedIn}", name="delete_interested_in")
     */
    public function deleteInterestedInAction(InterestedIn $interestedIn)
    {
        $user = $this->getUser();
        $user->removeInterestedIn($interestedIn);
        $this->getDoctrine()->getManager()->flush();
        return new JsonResponse();
    }
    
    /**
     * @Route("/repost/{post}-{user}-{comm}", name="repost")
     */
    public function repostAction(Post $post, User $user, Community $comm = null)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $nm = $this->get('notification_manager');
        
        if ($comm) {
            $post->addCommunity($comm);
            $em->flush();
            $nm->onSharePostInCommunity($comm, $post, $this->getUser());
        }
        $sharedPost = $em->getRepository(SharePost::class)->getSharedPost($user, $post);
        if ($sharedPost) {
            return new JsonResponse(); 
        } else {
            $sharedPost = new SharePost;
            $sharedPost->setPost($post)
                    ->setUser($user);
            $em->persist($sharedPost);
            $em->flush();
            
//            $nm->add($post->getAuthor(), $this->getUser(), Notification::TYPE_SHARE_MY_POST, $post );
            
            return new JsonResponse();
        }
    }
    
    /**
     * @Route("/repost-to-community/{post}-{comm}", name="repost_to_community")
     */
    public function repostToCommunityAction(Post $post, Community $comm = null)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $nm = $this->get('notification_manager');
        
        if ($comm) {
            $post->addCommunity($comm);
            $em->flush();
            $nm->onSharePostInCommunity($comm, $post, $this->getUser());
        }
        
        return new JsonResponse();
    }
    
    /**
     * @Route("/profile/ajax-send-message/{user}", name="send_ajax_message")
     */
    public function sendMessageAction(User $user, Request $request)
    {
        $mm = $this->get('message_manager');
        $messager = $mm->getMessager($this->getUser());
        $messager->send($user, $request->get('message'));
        return new JsonResponse(['message' => $request->get('message')]);
    }
    
    /**
     * @Route("/profile/ajax-send-feedback/impressions", name="send_feedback_impressions")
     */
    public function sendFeedbackImpressionsAction(Request $request)
    {
        $data = $request->get('impressions');
        
        $message = \Swift_Message::newInstance()
            ->setSubject('New feedback impressions')
            ->setFrom('no-reply@manavao.com')
            ->setTo(['contact@manavao.com'])
            ->setBody(
                $this->renderView('AppBundle:Mail:feedbackImpressions.html.twig', compact('data')),
                'text/html'
            )
        ;
        $this->get('mailer')->send($message);

        return new JsonResponse(['message'=> 'Thank you for your feedback.']);
    }

        /**
     * @Route("/profile/ajax-send-feedback/priorities", name="send_feedback_priorities")
     */
    public function sendFeedbackPrioritiesAction(Request $request)
    {
        $data = $request->get('priorities');
        
        $message = \Swift_Message::newInstance()
            ->setSubject('New feedback impressions')
            ->setFrom('no-reply@manavao.com')
            ->setTo(['contact@manavao.com'])
            ->setBody(
                $this->renderView('AppBundle:Mail:feedbackPriorities.html.twig', compact('data')),
                'text/html'
            )
        ;
        $this->get('mailer')->send($message);

        return new JsonResponse(['message'=> 'Thank you for your feedback.']);
    }
    
    /**
     * @Route("/profile/ajax-deletePost-{post}", name="delete-post-from-user-wall")
     */
    public function deletePostFromWallAction(Post $post)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        if ($user == $post->getAuthor()) {
            if ($post->getType() == Post::TYPE_UPDATE) {
                $em->remove($post->getUpdatePost());
            }
            elseif ($post->getType() == Post::TYPE_OPPORTUNITY) {
                $em->remove($post->getOpportunityPost());
            }
            $em->remove($post);
        }
        else {
            $shPost = $em->getRepository(SharePost::class)->getSharedPost($user, $post);
            $em->remove($shPost);
        }
        $em->flush();
        return new JsonResponse();
    }
    
    /**
     * @Route("/profile/ajax-deleteCommunityPost-{post}-{comm}", name="delete-post-from-community-wall")
     */
    public function deletePostFromCommunityAction(Post $post, Community $comm)
    {
        $em = $this->getDoctrine()->getManager();
        $post->removeCommunity($comm);
        $em->flush();
        return new JsonResponse();
    }
    
    /**
     * @Route("/profile/ajax-deleteSharedPost-{post}", name="delete-shared-post")
     */
    public function deleteSharedPostAction(Post $post)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $sharedPost = $em->getRepository(SharePost::class)->getSharedPost($user, $post);
        $em->remove($sharedPost);
        $em->flush();
        return new JsonResponse();
    }
    
    /**
     * @Route("/profile/ajax-getOppPopup-{post}", name="getOppPopup", defaults={"temp" = "oppPopup"})
     * @Route("/profile/ajax-getUpdatePopup-{post}", name="getUpdatePopup", defaults={"temp" = "updatePopup"})
     * @Route("/profile/ajax-getEventPopup-{post}", name="getEventPopup", defaults={"temp" = "eventPopup"})
     */
    public function getPopupAction(Post $post, $temp)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $comm = $em->getRepository(Community::class)->getCommunityNoPost($post, $user);
        return $this->render('AppBundle:Account:parts/'.$temp.'.html.twig',
                array('post' => $post, 'user' => $user, 'comm' => $comm));
    }
    
    /**
     * @Route("/profile/ajax-getLikePopup-{post}", name="getLikePopup")
     */
    public function getLikePopupAction(Post $post)
    {
        return $this->render('AppBundle:Account:parts/likePopup.html.twig',
                array('post' => $post));
    }
    
    /**
     * @Route("/profile/ajax-likePost-{post}", name="like-post")
     */
    public function likePostAction(Post $post)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $nm = $this->get('notification_manager');
        $user = $this->getUser();
        $likedPost = $em->getRepository(LikePost::class)->getLikePost($user, $post);
        if ($likedPost) {
            $em->remove($likedPost);
            $flag = false;
        } else {
            $likedPost = new LikePost;
            $likedPost->setPost($post)
                    ->setUser($user);
            $em->persist($likedPost);
            $flag = true;
            $nm->add($post->getAuthor(), $this->getUser(), Notification::TYPE_LIKE_MY_POST, $post );
        }
        $em->flush();
        return new JsonResponse(['flag' => $flag, 'user' => $user->getId(), 'src' =>  $user->getImage() ? $user->getImage()->getSrc() : '']);
    }
    
    /**
     * @Route("/profile/ajax-commentPost-{post}", name="comment-post")
     */
    public function addCommentAction(Post $post, Request $request)
    {
        $user = $this->getUser();
        $content = $request->get('comment');
        $comment = new Comment;
        $comment->setContent($content)
                ->setPost($post)
                ->setUser($user);
        $em = $this->getDoctrine()->getManager();
        $em->persist($comment);
        $em->flush();
        return new JsonResponse([
      'content' => $content,
      'time' => $comment->getCreatedAt()->format('H:i'),
      'date' => $comment->getCreatedAt()->format('d.m.Y'),
      'src' => $user->getImage()->getSrc(),
      ]);
    }
    
    /**
     * @Route("/profile/ajax-remove-notification-{notification}", name="ajax_remove_notification")
     */
    public function ajaxRemoveNotificationAction(Notification $notification)
    {
        $nm = $this->get('notification_manager');
        $nm->remove($notification);
        
        return new JsonResponse([]);
    }
    
    /**
     * @Route("/profile/ajax-mark-notification-{notification}", name="ajax_mark_notification")
     */
    public function ajaxMarkNotificationAction(Notification $notification)
    {
        $nm = $this->get('notification_manager');
        $nm->mark($notification);
        
        return new JsonResponse([]);
    }
    
    
}

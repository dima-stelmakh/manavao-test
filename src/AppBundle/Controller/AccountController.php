<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Bundles\StoreBundle\Entity\Post;
use Bundles\StoreBundle\Entity\SharePost;
use Bundles\StoreBundle\Entity\UpdatePost;
use Bundles\StoreBundle\Entity\OpportunityPost;
use Bundles\OptionBundle\Entity\PostCategory;
use Bundles\OptionBundle\Entity\Industry;
use Bundles\StoreBundle\Entity\Community;
use Bundles\UserBundle\Entity\User;
use Bundles\OptionBundle\Entity\Skill;
use Bundles\OptionBundle\Entity\AuthorType;
use Bundles\OptionBundle\Entity\ProjectType;
use Bundles\OptionBundle\Entity\EventType;
use Bundles\StoreBundle\Entity\EventPost;
use Bundles\UserBundle\Entity\Info;
use Bundles\OptionBundle\Entity\OrganisationSize;
use Bundles\OptionBundle\Entity\Category;
use Bundles\OptionBundle\Entity\InterestedIn;
use Bundles\OptionBundle\Entity\Department;
use Bundles\OptionBundle\Entity\Language;
use Bundles\OptionBundle\Entity\BusinessArea;
use Bundles\OptionBundle\Entity\Clients;
use Bundles\StoreBundle\Entity\Country;

class AccountController extends Controller
{
    /**
     * @Route("/profile-update", name="profile-update", defaults={"type" = 1})
     * @Route("/profile-opportunity", name="profile-opportunity", defaults={"type" = 2})
     * @Route("/profile-event", name="profile-event", defaults={"type" = 3})
     * @Route("/profile-members", name="profile-members", defaults={"type" = 4})
     * @Route("/profile", name="profile", defaults={"type" = null})
	 * @Route("/profile/", name="profile2", defaults={"type" = null})
     */
    public function indexAction(Request $request, $type)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $info = $user->getInform();
        if (!$info) {
            $info = new Info;
            $user->setInform($info);
            $em->persist($info);
            $em->flush();
        }

        $cat = $em->getRepository(PostCategory::class)->findAll();
        $ind = $em->getRepository(Industry::class)->findAll();
        //$skill = $em->getRepository(Skill::class)->findAll();
        $projectType = $em->getRepository(ProjectType::class)->findAll();
        $authorType = $em->getRepository(AuthorType::class)->findAll();
        $comm = $em->getRepository(Community::class)->getCommunityByUser($user);
        if ($type == 4) {
            $post = $em->getRepository(Post::class)->getNewsPost($comm, null, $user);
//            $fs = $this->get('friend_manager');
//            $friends = $fs->getFriends($user);
//            $post = $em->getRepository(Post::class)->getFriendsPosts($friends);
        } else {
            $post = $em->getRepository(Post::class)->getNewsPost($comm, $type);
        }
//        dump($post); die;
        $eventType = $em->getRepository(EventType::class)->findAll();
        $users = $em->getRepository(User::class)->getLastUsers($user, 6);
        $nearly = $em->getRepository(Community::class)->getNearly($user, 6);
        return $this->render('AppBundle:Account:index.html.twig',
                compact('cat', 'ind', 'comm', 'post', 'user', 'skill', 'projectType', 'authorType', 'users', 'eventType', 'nearly', 'type'));
    }

    /**
     * @Route("/profile/organisation", name="profile_organisation")
     */
    public function organisationPageAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository(User::class)->getLastUsers($this->getUser(), 6);
        $sizes = $em->getRepository(OrganisationSize::class)->findAll();
        $cats = $em->getRepository(Category::class)->findAll();
        $deps = $em->getRepository(Department::class)->findAll();
        $langs = $em->getRepository(Language::class)->findAll();
        $interestedIn = $em->getRepository(InterestedIn::class)->findAll();
        $business = $em->getRepository(BusinessArea::class)->findAll();
        $ind = $em->getRepository(Industry::class)->findAll();
        $clients = $em->getRepository(Clients::class)->findAll();
        $countries = $this->getDoctrine()->getRepository(Country::class)->findAll();

        return $this->render('AppBundle:Account:organisationPage.html.twig',
                compact('users', 'sizes', 'cats', 'deps', 'langs', 'interestedIn', 'business', 'ind', 'clients', 'countries' ));
    }

    /**
     * @Route("/profile/organisation-purchase", name="profile_organisation_purchase")
     */
    public function organisationPurchaseAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository(User::class)->getLastUsers($this->getUser(), 6);
        $sizes = $em->getRepository(OrganisationSize::class)->findAll();
        $cats = $em->getRepository(Category::class)->findAll();
        $deps = $em->getRepository(Department::class)->findAll();
        $langs = $em->getRepository(Language::class)->findAll();
        $interestedIn = $em->getRepository(InterestedIn::class)->findAll();
        $business = $em->getRepository(BusinessArea::class)->findAll();
        $ind = $em->getRepository(Industry::class)->findAll();
        $clients = $em->getRepository(Clients::class)->findAll();
        $countries = $this->getDoctrine()->getRepository(Country::class)->findAll();

        return $this->render('AppBundle:Account:organisationPurchase.html.twig',
                compact('users', 'sizes', 'cats', 'deps', 'langs', 'interestedIn', 'business', 'ind', 'clients', 'countries' ));
    }

    /**
     * @Route("/addPostForm", name="add-post-form")
     */
    public function addPostFormAction(Request $request)
    {
//        dump($request->get('community')); die;
        $user =  $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $type = $request->get('type');
        $post = new Post;
        $post->setAuthor($user)
                ->setContent($request->get('content'));
        $comm = $request->get('community');
        $communities = [];
        if ($comm) {
            if ($comm[0] == 'all') {
                $communities = $user->getCommunities();
            } else {
                foreach ($comm as $elem) {
                    $community = $em->find(Community::class, $elem);
                    $communities[] = $community;
                }
            }
            $nm = $this->get('notification_manager');
            foreach ($communities as $community) {
//                $community = $em->find(Community::class, $elem);
                $post->addCommunity($community);
                $nm->onSharePostInCommunity($community, $post, $this->getUser(), false);
            }
        }
        if ($type == 1) {
            $post->setType(Post::TYPE_UPDATE);
            $updatePost = new UpdatePost;
            $updatePost->setPostCategory($em->find(PostCategory::class, $request->get('category')))
                    ->setIndustry($em->find(Industry::class, $request->get('industry')));
            $em->persist($updatePost);
            $post->setUpdatePost($updatePost);
            $em->persist($post);
        }
        if ($type == 2) {
            //dump($request); die;
            $post->setType(Post::TYPE_OPPORTUNITY);
            $oppPost = new OpportunityPost;
            $oppPost->setFewWords($request->get('few-words'))
                    ->setDeadline(new \DateTime(str_replace('/', '-', $request->get('deadline'))))
                    ->setAuthorType($em->find(AuthorType::class, $request->get('author-type')))
                    ->setProjectType($em->find(ProjectType::class, $request->get('project-type')))
                    //->setSkill($em->find(Skill::class, $request->get('skill')))
//                    ->setSkill($request->get('skill'))
                    ->setIndustry($em->find(Industry::class, $request->get('industry')))
                    ->setIsMyNameConfidential((bool)!$request->get('is-my-name-confidential'))
                    ->setReadyToContact((bool)!$request->get('ready-to-contact'))
                    ->setShowToEveryone((bool)!$request->get('show-to-everyone'));
            $em->persist($oppPost);
            $post->setOpportunityPost($oppPost);
            $em->persist($post);
        }
        if ($type == 3) {
            $post->setType(Post::TYPE_EVENT);
            $eventPost = new EventPost;
            $eventPost->setName($request->get('name'))
                    ->setIndustry($em->find(Industry::class, $request->get('industry')))
                    ->setEventType($em->find(EventType::class, $request->get('typeOfEvent')))
                    ->setEndDate(new \DateTime(str_replace('/', '-', $request->get('end_date'))))
                    ->setStartDate(new \DateTime(str_replace('/', '-', $request->get('start_date'))))
                    ->setLocation($request->get('location'))
                    ->setLink($request->get('link'))
                    ->setOnlyToMeShow($request->get('onlyToMeShow'))
                    ->setLat($request->get('lat'))
                    ->setLng($request->get('lng'))
                    ;
            $em->persist($eventPost);
            $post->setEventPost($eventPost);
            $em->persist($post);
        }
        $em->flush();
        if ($request->get('check')) {
            return $this->redirectToRoute('community', ['comm' => $request->get('check')]);
        } else {
            return $this->redirectToRoute('profile');
        }
    }



    /**
     * @Route("/profile/community-update-{comm}", name="community-update", defaults={"type" = 1})
     * @Route("/profile/community-opportunity-{comm}", name="community-opportunity", defaults={"type" = 2})
     * @Route("/profile/community-event-{comm}", name="community-event", defaults={"type" = 3})
     * @Route("/profile/community-{comm}", name="community", defaults={"type" = null})
     */
    public function communityAction(Community $comm, $type)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository(Post::class)->getCommunityPost($comm, $type);
        $lastUsers = $em->getRepository(User::class)->getLastUsersInComm($comm, 6);
        $cat = $em->getRepository(PostCategory::class)->findAll();
        $ind = $em->getRepository(Industry::class)->findAll();
        //$skill = $em->getRepository(Skill::class)->findAll();
        $projectType = $em->getRepository(ProjectType::class)->findAll();
        $authorType = $em->getRepository(AuthorType::class)->findAll();
        $eventType = $em->getRepository(EventType::class)->findAll();
        $cats = $em->getRepository(Category::class)->findAll();
        $nearly = $em->getRepository(Community::class)->getNearlyForCommunity($comm, 6);
        return $this->render('AppBundle:Account:community.html.twig',
                compact('comm', 'post', 'lastUsers', 'user', 'cat', 'ind', 'projectType', 'authorType', 'eventType', 'cats', 'nearly'));
    }

    /**
     * @Route("/profile/community-members/{community}", name="community_members")
     */
    public function communityMemberListAction(Request $request, Community $community)
    {
        $em = $this->getDoctrine()->getManager();
        $lcm = $this->get('last_connection_manager');
        $query = $lcm->getCommunityMembersQuery($community);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            20/*limit per page*/
        );

        $nearly = $em->getRepository(Community::class)->getNearly($this->getUser(), 6);

        return $this->render('AppBundle:Account:communityMemberList.html.twig', compact('pagination', 'nearly', 'community'));
    }

    /**
     * @Route("/event-date/{eventdate}", name="event-date", defaults={"eventdate" = null})
     */
    public function profileEvent(Request $request, $eventdate)
    {
      $em = $this->getDoctrine()->getManager();
      $nearly = $em->getRepository(Community::class)->getNearly($this->getUser(), 6);
      $users = $em->getRepository(User::class)->getLastUsers($this->getUser(), 6);
      return $this->render('AppBundle:Main:event.html.twig', compact('nearly', 'users'));
    }

    /**
     * @Route("/profile/add-friend-{someUser}", name="add-friend")
     */
    public function addFriendAction(User $someUser, Request $request)
    {
        $fs = $this->get('friend_manager');
        $fs->add($this->getUser(), $someUser);

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @Route("/profile/remove-friend-{someUser}", name="remove-friend")
     */
    public function removeFriendAction(User $someUser, Request $request)
    {
        $fs = $this->get('friend_manager');
        $fs->remove($this->getUser(), $someUser);

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @Route("/profile/updates-user-{someUser}", name="some-user-page-update", defaults={"type" = 1})
     * @Route("/profile/opportuniries-user-{someUser}", name="some-user-page-opportunity", defaults={"type" = 2})
     * @Route("/profile/events-user-{someUser}", name="some-user-page-event", defaults={"type" = 3})
     * @Route("/profile/connections-user-{someUser}", name="some-user-page-connections", defaults={"type" = 4})
     * @Route("/profile/user-{someUser}", name="some-user-page", defaults={"type" = null})
     */
    public function userPageAction(User $someUser, $type)
    {
        $showPosts = $type ? true : false;

        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
//        $info = $someUser->getInform();
        if ($type ==  4) {
            $fs = $this->get('friend_manager');
            $friends = $fs->getFriends($someUser);
//            dump($friends); die;
            $post = $em->getRepository(Post::class)->getFriendsPosts($friends);
        } else {
            $post = $em->getRepository(Post::class)->getUserWallPost($someUser, $type);
        }

        $skill = $em->getRepository(Skill::class)->findAll();
        $sizes = $em->getRepository(OrganisationSize::class)->findAll();
        $cats = $em->getRepository(Category::class)->findAll();
        $deps = $em->getRepository(Department::class)->findAll();
        $langs = $em->getRepository(Language::class)->findAll();
        $interestedIn = $em->getRepository(InterestedIn::class)->findAll();
        $business = $em->getRepository(BusinessArea::class)->findAll();
        $ind = $em->getRepository(Industry::class)->findAll();
        $clients = $em->getRepository(Clients::class)->findAll();
        $countries = $this->getDoctrine()->getRepository(Country::class)->findAll();

        if ($user !=  $someUser) {
            $mm = $this->get('message_manager');
            $messager = $mm->getMessager($this->getUser());
            $messages = $messager->getMessages($someUser);
        }


        return $this->render('AppBundle:Account:userPage.html.twig',
                compact('post', 'someUser', 'users', 'business', 'sizes', 'cats', 'deps', 'langs', 'interestedIn', 'ind', 'clients', 'countries', 'messages', 'skill', 'showPosts', 'type'));
    }

    /**
     * @Route("/profile/communities", name="profile_communities")
     */
    public function userPageBusinessCommunitiesAction()
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository(Post::class)->getUserWallPost($user);
        $users = $em->getRepository(User::class)->getLastUsers($user, 6);

        return $this->render('AppBundle:Account:userPageBusinessCommunities.html.twig',
                compact('post', 'user', 'users'));
    }

    /**
     * @Route("/profile/edit-tabs", name="profile_edit")
     */
    public function userPageTabsEditInfoAction()
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository(Post::class)->getUserWallPost($user);
        $users = $em->getRepository(User::class)->getLastUsers($user, 6);

        return $this->render('AppBundle:Account:userPageTabsEdit.html.twig',
                compact('post', 'user', 'users'));
    }

    /**
     * @Route("/profile/info", name="profile_info")
     */
    public function userPageBusinessInfoAction()
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
    //    $post = $em->getRepository(Post::class)->getUserWallPost($user);
        $users = $em->getRepository(User::class)->getLastUsers($user, 6);

        return $this->render('AppBundle:Account:userPageBusinessInfo.html.twig',
                compact('user', 'users'));
    }

    /**
     * @Route("/profile/last-friends/{user}", name="profile_last_someuser_friends", defaults={"currentTab" = 1})
     * @Route("/profile/users-friends/{user}", name="profile_someuser_friends", defaults={"currentTab" = 2})
     */
    public function userListSomeoneFriends(Request $request, User $user, $currentTab)
    {
        $fm = $this->get('friend_manager');
        $query = $fm->getFriendsQuery($user);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            20/*limit per page*/
        );

        $em = $this->getDoctrine()->getManager();
        $nearly = $em->getRepository(Community::class)->getNearly($user, 6);

        return $this->render('AppBundle:Account:userListSomeoneFriends.html.twig', compact('pagination', 'nearly', 'user', 'currentTab'));
    }

    /**
     * @Route("/profile/last-members", name="profile_last_members", defaults={"currentTab" = 1})
     * @Route("/profile/members", name="profile_members", defaults={"currentTab" = 2})
     * @Route("/profile/suggestions", name="profile_suggestions", defaults={"currentTab" = 3})
     */
    public function membersAction(Request $request, $currentTab)
    {
        $em = $this->getDoctrine()->getManager();
        $lcm = $this->get('last_connection_manager');

        if ($currentTab == 1) {
            $query = $lcm->getUsersInMyCommunitiesQuery($this->getUser());
        } elseif ($currentTab == 2) {
            $query = $lcm->getUsersInMyCommunitiesSortByNameQuery($this->getUser());
        }  elseif ($currentTab == 3) {
            $query = $lcm->getLastConnectionsQuery($this->getUser());
        }

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            20/*limit per page*/
        );

        $nearly = $em->getRepository(Community::class)->getNearly($this->getUser(), 6);

        return $this->render('AppBundle:Account:memberListMembers.html.twig', compact('pagination', 'nearly', 'currentTab'));
    }

    /**
     * @Route("/profile/last-followers", name="profile_last_followers")
     */
    public function userListLastFollowersAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $lcm = $this->get('last_connection_manager');
        $query = $lcm->getUsersInMyCommunitiesQuery($this->getUser());
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            20/*limit per page*/
        );

        $nearly = $em->getRepository(Community::class)->getNearly($this->getUser(), 6);

        return $this->render('AppBundle:Account:userListLastFollowers.html.twig', compact('pagination', 'nearly'));
    }

    /**
     * @Route("/profile/message", name="profile_message", defaults={"userId":null})
     * @Route("/profile/message/{userId}", name="profile_message_user")
     */
    public function userPageMessageAction($userId)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository(User::class)->getLastUsers($user, 6);

        $mm = $this->get('message_manager');
        $messager = $mm->getMessager($this->getUser());

        $dialogs = $messager->getDialogs();

        if (empty($dialogs)) {
            return $this->render('AppBundle:Account:emptyMessage.html.twig');
        }

        if ($userId) {
            $conv = $em->find(User::class, $userId);
        } else {
            $conv = $dialogs[0]['user'];
        }

        $messages = $messager->getMessages($conv);

        return $this->render('AppBundle:Account:userPageMessage.html.twig',
                compact('user', 'users', 'dialogs', 'messages', 'conv'));
    }

    /**
     * @Route("/profile/send-message/{user}", name="send_message")
     */
    public function sendMessageAction(User $user, Request $request)
    {
        $mm = $this->get('message_manager');
        $messager = $mm->getMessager($this->getUser());
        $messager->send($user, $request->get('message'));
        return $this->redirectToRoute('profile_message_user', ['userId' => $user->getId()]);
    }

    /**
     * @Route("/profile/edit-info", name="edit-info")
     */
    public function editInfoAction(Request $request)
    {
        $user = $this->getUser();
        $request->get('linkedIn') ? $user->setLinkedIn($request->get('linkedIn')) : 1;
        $em = $this->getDoctrine()->getManager();

        $info = $user->getInform();
        $request->get('overview') ? $info->setOverview($request->get('overview')) : 1;
        $request->get('organisation') ? $info->setOrganisation($request->get('organisation')) : 1;
        $request->get('orgType') ? $user->setCategory($em->find(Category::class, $request->get('orgType'))) : 1;
        $request->get('orgSize') ? $info->setOrgSize($em->find(OrganisationSize::class, $request->get('orgSize'))) : 1;
        $request->get('summary') ? $info->setSummary($request->get('summary')) : 1;
        $request->get('businessArea') ? $info->setBusinessArea($em->find(BusinessArea::class, $request->get('businessArea'))) : 1;
        $request->get('clients') ? $info->setClients($em->find(Clients::class, $request->get('clients'))) : 1;
        $request->get('purchaseArea') ? $info->setPurchaseArea($request->get('purchaseArea')) : 1;
        $request->get('clubs') ? $info->setClubs($request->get('clubs')) : 1;
//        $request->get('interestedIn') ? $info->setInterestedIn($request->get('interestedIn')) : 1;
        $request->get('twitter') ? $info->setTwitter($request->get('twitter')) : 1;
        $request->get('youtube') ? $info->setYoutube($request->get('youtube')) : 1;
        $request->get('facebook') ? $info->setFacebook($request->get('facebook')) : 1;
        $request->get('website') ? $info->setwebsite($request->get('website')) : 1;
        $request->get('docs') ? $info->setDocs($request->get('docs')) : 1;
        if ($request->get('interestedIn')) {
            $user->removeAllInterestedIn();
            foreach ($request->get('interestedIn') as $item) {
                $user->addInterestedIn($em->find(InterestedIn::class, $item));
            }
        }
        $em->flush();
        return $this->redirectToRoute('some-user-page', ['someUser' => $user->getId()]);
    }

    /**
     * @Route("/profile/individual", name="profile_individual_info")
     */
    public function userPageIndividualInfoAction()
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository(Post::class)->getUserWallPost($user);
        $users = $em->getRepository(User::class)->getLastUsers($user, 6);

        return $this->render('AppBundle:Account:userPageIndividualInfo.html.twig',
                compact('post', 'user', 'users'));
    }

    /**
     * @Route("/profile/edit-individual", name="edit-individual")
     */
    public function editIndividualAction(Request $request)
    {
//        dump($request); die;
        $user = $this->getUser();
        $request->get('linkedIn') ? $user->setLinkedIn($request->get('linkedIn')) : 1;
        $request->get('phone') ? $user->setPhone($request->get('phone')) : 1;
        $request->get('address') ? $user->setAddress($request->get('address')) : 1;
        $request->get('im') ? $user->setIM($request->get('im')) : 1;
        $em = $this->getDoctrine()->getManager();

        $info = $user->getInform();
        $request->get('overview') ? $info->setOverview($request->get('overview')) : 1;
        $request->get('currentSummary') ? $info->setCurrentSummary($request->get('currentSummary')) : 1;
        $request->get('currentPosition') ? $user->setJob($request->get('currentPosition')) : 1;
        $request->get('department') ? $info->setDepartment($em->find(Department::class, $request->get('department'))) : 1;
        $request->get('email') ? $info->setEmail($request->get('email')) : 1;
//        $request->get('skills') ? $info->setSkills($request->get('skills')) : 1;
        $request->get('education') ? $info->setEducation($request->get('education')) : 1;
//        $request->get('language') ? $info->setLang($em->find(Language::class, $request->get('language'))) : 1;
        $request->get('interests') ? $info->setInterests($request->get('interests')) : 1;
        $request->get('localResp') ? $info->setLocalResp($request->get('localResp')) : 1;
        $request->get('industry') ? $user->setIndustry($em->find(Industry::class, $request->get('industry'))) : 1;
        if ($request->get('skills')) {
            $info->removeAllSkills();
            foreach ($request->get('skills') as $item) {
                $info->addSkill($em->find(Skill::class, $item));
            }
        }
        if ($request->get('langs')) {
            $info->removeAllLangs();
            foreach ($request->get('langs') as $item) {
                $info->addLang($em->find(Language::class, $item));
            }
        }
        $em->flush();
        return $this->redirectToRoute('some-user-page', ['someUser' => $user->getId()]);
    }

}

<?php

namespace Bundles\StoreBundle\Service;

use Bundles\UserBundle\Entity\User;
use Bundles\StoreBundle\Entity\Notification;
use Bundles\StoreBundle\Entity\Community;
use Bundles\StoreBundle\Entity\Post;


class NotificationManager
{
    private $container;
    private $repo;
    private $user;
    private $em;
        
    public function __construct($container) {
        $this->container = $container;
        $this->em = $container->get('doctrine.orm.entity_manager');
        $this->repo = $this->em->getRepository(Notification::class);
        $this->user = $this->getUser();
    }
    
    public function getList()
    {
        return $this->repo->findBy(['user' => $this->user ], ['id' => 'DESC']);
    }
    
    public function newCount()
    {
        return count($this->repo->findBy(['user' => $this->user, 'new' => true ]));
    }
    
        
    public function add(User $user, User $aboutUser, $type, $post = null, $community = null, $flush = true)
    {
        $item = new Notification;
        $item
            ->setUser($user)
            ->setAboutUser($aboutUser)
            ->setNoteType($type)
            ->setPost($post)
            ->setCommunity($community)
            ;
        $this->em->persist($item);
        
        if ($flush) {
            $this->em->flush();
        }
        
        // call websoket here
    }
        
    public function remove(Notification $notification, $flush = true)
    {
        $this->em->remove($notification);
        
        if ($flush) {
            $this->em->flush();
        }
    }
    
    public function markAllAsRead()
    {
        $notes = $this->getList();
        
        foreach ($notes as $note) {
            $this->mark($notification, false);
        }
        $this->em->flush();
    }
    
    public function mark(Notification $notification, $flush = true)
    {
        $notification->setNew(false);
        
        if ($flush) {
            $this->em->flush();
        }
    }
    
    public function joinToCommunity(User $user, Community $comm)
    {
        $users = $comm->getUsers();
        foreach ($users as $us) {
            $this->add($us, $user, Notification::TYPE_USER_JOINED_TO_COMMUNITY, null, $comm );
        }
    }
    
    public function onSharePostInCommunity(Community $comm, Post $post, User $user, $flush = true)
    {
        $users = $comm->getUsers();
        
        foreach ($users as $us) {
            if ($post->getAuthor() == $user) {
                $this->add($us, $user, Notification::TYPE_POSTED_IN_COMMUNITY, $post, $comm, $flush);
            } else {
                $this->add($us, $user, Notification::TYPE_SHARE_MY_POST, $post, $comm, $flush );
            } 
        }
    }
    
    private function getUser()
    {
        if (null === $token = $this->container->get('security.token_storage')->getToken()) {
            return;
        }

        if (!is_object($user = $token->getUser())) {
            // e.g. anonymous authentication
            return;
        }

        return $user;
    }
}
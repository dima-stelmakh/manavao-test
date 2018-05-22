<?php

namespace Bundles\StoreBundle\Service;

use Bundles\StoreBundle\Entity\Friend;
use Bundles\UserBundle\Entity\User;

class FriendManager
{
    private $container;
    private $em;
    private $userRepo;
    private $friendRepo;

    public function __construct($container) {
        $this->container = $container;
        $this->em = $container->get('doctrine.orm.entity_manager');
        $this->userRepo = $this->em->getRepository(User::class);
        $this->friendRepo = $this->em->getRepository(Friend::class);
    }

    public function add($user, $friend)
    {
        if ($this->isFriend($user, $friend)) {
            return false;
        }
        
        $item = new Friend;
        $item->setUser($user);
        $item->setFriend($friend);
        $item->setStatus(Friend::STATUS_CONFIRMED);
        $this->em->persist($item);
        $this->em->flush();
    }
    
    public function remove($user, $friend)
    {
        
        if (!$this->isFriend($user, $friend)) {
            return false;
        }
        $fr = $this->isFriend($user, $friend);

        $this->em->remove($fr);
        $this->em->flush();
    }
    
    public function isFriend($user, $friend)
    {
        $out = $this->friendRepo->findOneBy(['user' => $user, 'friend' => $friend, 'status' => Friend::STATUS_CONFIRMED]);
        if ($out) {
            return $out;
        }
        
        $in = $this->friendRepo->findOneBy(['user' => $friend, 'friend' => $user, 'status' => Friend::STATUS_CONFIRMED]);
        if ($in) {
            return $in;
        }
        
        return false;
    }
    
    public function getFriendsQuery($user)
    {
        return $this->userRepo->getFriendsQuery($user);
    }
            
    public function getFriends($user, $limit = null)
    {
        return $this->userRepo->getFriendsQuery($user, $limit)->getResult();
    }
    
    public function getFriendCount($user)
    {
        $query = $this->getFriendsQuery($user);
        return count($query->getResult());
    }
}

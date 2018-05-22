<?php

namespace Bundles\StoreBundle\Service;

use Bundles\UserBundle\Entity\User;
use Bundles\StoreBundle\Entity\Community;

class LastConnectionManager
{
    private $container;
    private $em;
    private $userRepo;

    public function __construct($container) {
        $this->container = $container;
        $this->em = $container->get('doctrine.orm.entity_manager');
        $this->userRepo = $this->em->getRepository(User::class);
    }
    
    public function getCommunityMembersQuery(Community $comm)
    {
        return $this->userRepo->getCommunityMembersQuery($comm);
    }
    
    
    public function getLastConnectionsQuery(User $user)
    {
        return $this->userRepo->getLastUsersQuery($user);
    }
    
    public function getUsersInMyCommunitiesQuery(User $user)
    {
        return $this->userRepo->getUsersInMyCommunitiesQuery($user);
    }
    
    public function getUsersInMyCommunitiesSortByNameQuery(User $user)
    {
        return $this->userRepo->getUsersInMyCommunitiesQuery($user, 1);
    }
    
    public function getLastConnections(User $user, $count = 25)
    {
        $lastUsers = $this->userRepo->getLastUsers($user, $count);
        return $lastUsers;
    }
    
    public function getLastInCommunity(Community $comm, $count = 25)
    {
        $lastUsers = $this->userRepo->getLastUsersInComm($comm, $count);
        return $lastUsers;
    }
    
    public function getLastConnectionCount(User $user)
    {
        $query = $this->getLastConnectionsQuery($user);
        return count($query->getResult());
    }
    
    public function getUsersInMyCommunitiesQueryCount(User $user)
    {
        $query = $this->getUsersInMyCommunitiesQuery($user);
        return count($query->getResult());
    }  
}

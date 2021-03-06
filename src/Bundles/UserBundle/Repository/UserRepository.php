<?php

namespace Bundles\UserBundle\Repository;

use Bundles\StoreBundle\Entity\Community;
use Bundles\UserBundle\Entity\User;
use Bundles\StoreBundle\Entity\Friend;
/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends \Doctrine\ORM\EntityRepository
{
    public function getLastUsers(User $user, $limit)
    {
        return $this->createQueryBuilder('user')
                ->where('user.id != :user')
                ->join('user.inform', 'inform')
                ->setParameter('user', $user)
                ->orderBy('user.createdAt', 'DESC')
                ->setMaxResults($limit)
                ->getQuery()
                ->getResult()
                ;
    }
    
    public function getLastUsersQuery(User $user)
    {
        return $this->createQueryBuilder('user')
                ->join('user.inform', 'inform')
                ->where('user.id != :user')
                ->setParameter('user', $user)
                ->orderBy('user.createdAt', 'DESC')
                ->getQuery()
                ;
    }
    
    public function getUsersInMyCommunitiesQuery(User $user, $sortByName = null)
    {
        $qb =  $this->createQueryBuilder('user')
            ->join('user.inform', 'inform')
            ;
            foreach ($user->getCommunities() as $key => $comm) {
                $qb
                    ->orWhere(":comm$key MEMBER OF user.communities")
                    ->setParameter("comm$key", $comm)
                ;

            }
            $qb
            ->andWhere('user.id != :user')
            ->setParameter('user', $user)
            ;
            
            if ($sortByName){
                $qb->orderBy('user.firstName', 'ASC');
            } else {
                $qb->orderBy('user.createdAt', 'DESC');
            }
        
        return $qb
            ->distinct()
            ->getQuery()
            ;
    }
    
    public function getCommunityMembersQuery(Community $comm)
    {
        return $this->createQueryBuilder('user')
                ->join('user.inform', 'inform')
                ->where(':comm MEMBER OF user.communities')
                ->setParameter('comm', $comm)
                ->getQuery();
    }
    
    
    public function getLastUsersInComm(Community $comm, $limit)
    {
        return $this->createQueryBuilder('user')
                ->join('user.inform', 'inform')
                ->where(':comm MEMBER OF user.communities')
                ->setParameter('comm', $comm)
                ->setMaxResults($limit)
                ->getQuery()
                ->getResult();
    }
    public function getFriendsQuery($user, $limit = null)
    {
        $qb = $this->createQueryBuilder('user')
            ->leftJoin('user.friendUsers', 'frUser', 'WITH', 'frUser.status = :status')
            ->leftJoin('user.friends', 'friend', 'WITH', 'friend.status = :status')
            ->orWhere('frUser.user = :user')
            ->orWhere('frUser.friend = :user')
            ->orWhere('friend.user = :user')
            ->orWhere('friend.friend = :user')
            ->andWhere('user.id != :user')
            ->setParameter('user', $user)
            ->setParameter('status', Friend::STATUS_CONFIRMED)
            ;
        
        if ($limit) {
            $qb->setMaxResults($limit);
        }
        
        return $qb
            ->distinct()
            ->getQuery()
            ;
        
    }
    
}

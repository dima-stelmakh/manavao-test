<?php

namespace Bundles\StoreBundle\Repository;

/**
 * UrbanAreaRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UrbanAreaRepository extends \Doctrine\ORM\EntityRepository
{
    public function getArray($countryId)
    {
        $qb = $this->createQueryBuilder('ua')
            ->select('ua.id, ua.name')
            ->where('ua.country = '.$countryId)
            ->orderBy('ua.name', 'ASC')
            ->getQuery()
        ;
        
        return $qb->getArrayResult();
    }
    
    public function getAreasWithoutCommunity()
    {
        $qb = $this->createQueryBuilder('ua')
            ->leftJoin('ua.community', 'comm')
            ->where('comm.id IS NULL')
            ->getQuery()
        ;
        
        return $qb->getResult();
    }
}

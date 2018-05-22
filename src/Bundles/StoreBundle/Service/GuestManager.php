<?php

namespace Bundles\StoreBundle\Service;

use Bundles\UserBundle\Entity\User;
use Bundles\StoreBundle\Entity\Community;

class GuestManager
{
    private $container;
    private $em;
    private $userRepo;

    public function __construct($container) {
        $this->container = $container;
        $this->em = $container->get('doctrine.orm.entity_manager');
        $this->userRepo = $this->em->getRepository(User::class);
    }
    
    public function visit(User $user, User $guest)
    {
        return true;
    }
}

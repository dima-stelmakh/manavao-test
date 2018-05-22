<?php

namespace Bundles\StoreBundle\Service;

use Bundles\UserBundle\Entity\User;
use Bundles\StoreBundle\Model\Messager;
use Bundles\StoreBundle\Entity\Message;


class MessageManager
{
    private $container;
    private $em;
    private $repo;
    
    public function __construct($container) {
        $this->container = $container;
        $this->em = $container->get('doctrine.orm.entity_manager');
        $this->repo = $this->em->getRepository(Message::class);
    }
    
    public function getMessager(User $user)
    {
        return new Messager($this->container, $user);
    }
    
    public function unreadCount(User $user)
    {
        return $this->repo->unreadCount($user);
    }
    
    public function readMessage(Message $message)
    {
        $message->setViewed(true);
        $this->em->flush();
    }
    
    public function send(User $sender, User $user, $text)
    {
        $item = new Message;
        $item
            ->setSender($sender)
            ->setUser($user)
            ->setText($text)
            ;
        $this->em->persist($item);
        $this->em->flush();
        
    }
}

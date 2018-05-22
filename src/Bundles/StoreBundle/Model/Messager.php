<?php

namespace Bundles\StoreBundle\Model;

use Bundles\UserBundle\Entity\User;
use Bundles\StoreBundle\Entity\Message;

class Messager
{
    private $container;
    private $em;
    private $user;
    private $manager;
    private $repo;

    public function __construct($container, User $user) {
        $this->container = $container;
        $this->em = $container->get('doctrine.orm.entity_manager');
        $this->manager = $container->get('message_manager');
        $this->user = $user;
        $this->repo = $this->em->getRepository(Message::class);
    }
    
    public function getMessages(User $user)
    {
        $messages = $this->repo->getDialog($this->user, $user);
        $this->em->flush();
        return $messages;
    }
    
    public function getDialogs()
    {
        $dialogs = [];
        $arr = $this->repo->getDialogs($this->user);
        
        foreach ($arr as $item) {
            $dialogs[] = $this->createDialogItem($item);
        }
        
        return $dialogs;
    }
    
    public function send(User $user, $text)
    {
        $this->manager->send($this->user, $user, $text);
    }

    private function createDialogItem($data)
    {
        if ( $data['sender_id'] == $this->user->getId() ) {
            $my = true;
            $user = $this->em->find(User::class, $data['user_id'] );
        } else {
            $my = false;
            $user = $this->em->find(User::class, $data['sender_id'] );
        }
        
        return [
            'myLastMessage' => $my,
            'user' => $user,
            'message' => $this->repo->find($data['message_id']),
        ];
        
    }
    
}

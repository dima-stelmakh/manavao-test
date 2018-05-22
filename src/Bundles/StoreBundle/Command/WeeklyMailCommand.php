<?php

namespace Bundles\StoreBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Bundles\StoreBundle\Entity\Community;
use Bundles\UserBundle\Entity\User;
use Bundles\StoreBundle\Entity\Post;


class WeeklyMailCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('store:weekly-mail:send')
            ->setDescription('Weekly mail sending')
            ->setHelp("This command allows you to send mails about communities changes")
        ;
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $mailer = $this->getContainer()->get('mailer');
        $comms = $em->getRepository(Community::class)->getWithUsersCommunities();
        foreach ($comms as $comm) {
            $lastUsers = $em->getRepository(User::class)->getLastUsersInComm($comm, 6);
            $today = new \DateTime;
            $weekAgo = clone $today;
            $weekAgo = $today->sub(new \DateInterval('P7D'));
            $updatePosts = $em->getRepository(Post::class)->getLasWeekCommunityPost($comm, $weekAgo, $today, 1);
            $oppPosts = $em->getRepository(Post::class)->getLasWeekCommunityPost($comm, $weekAgo, $today, 2);
            $eventPosts = $em->getRepository(Post::class)->getLasWeekCommunityPost($comm, $weekAgo, $today, 3);
            $users = $comm->getUsers();
            foreach ($users as $user) {
                $message = \Swift_Message::newInstance()
                    ->setSubject('Weekly communities news')
                    ->setFrom('info@communities.com')
                    ->setTo($user->getEmail())
                    ->setBody(
                        $this->getContainer()->get('templating')->render(
                            // app/Resources/views/Emails/registration.html.twig
                            'Emails/weeklyMail.html.twig',
                            array('comm' => $comm, 'lastUsers' => $lastUsers, 'updatePosts' => $updatePosts, 
                                'oppPosts' => $oppPosts, 'eventPosts' => $eventPosts, 'user' => $user)
                        ),
                        'text/html'
                    )
                ;
            }

        $mailer->send($message);
        }
    }
}
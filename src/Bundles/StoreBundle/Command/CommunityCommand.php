<?php

namespace Bundles\StoreBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Bundles\StoreBundle\Entity\City;
use Bundles\StoreBundle\Entity\UrbanArea;
use Bundles\StoreBundle\Entity\Community;

class CommunityCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('store:communities:load')
            ->setDescription('Creates new users.')
            ->setHelp("This command allows you to create users...")
        ;
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $urbanRepo = $em->getRepository(UrbanArea::class);

        $areas = $urbanRepo->getAreasWithoutCommunity();
        $output->writeln(count($areas));
        $iterator = 0;
        foreach ($areas as $area) {
            if (null !== $area->getCommunity()) {
                continue;
            }
            $comm = new Community;
           
            $comm
                ->setName($area->getName() . ' Business Community')
                ->setArea($area)
                ->setCity($area->getName())
            ;
            $em->persist($comm);
            $output->writeln($area->getCountry()->getName() . ' - ' .$area->getName());
            if ($iterator++ > 100 ) {
                $em->flush();
                $iterator = 0;
                $output->writeln('COMMIT!');
            }
        }
        
        $em->flush();
        $output->writeln('DONE!');
    }
}
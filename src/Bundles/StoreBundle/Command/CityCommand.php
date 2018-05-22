<?php

namespace Bundles\StoreBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Bundles\StoreBundle\Entity\City;
use Bundles\StoreBundle\Entity\UrbanArea;
use Bundles\StoreBundle\Entity\Country;

class CityCommand extends ContainerAwareCommand
{
    private $em;
    private $cityRepo;


    protected function configure()
    {
        $this
            ->setName('store:cities:load')
            ->setDescription('Creates new users.')
            ->setHelp("This command allows you to create users...")
        ;
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filePath = __DIR__ . '/cities.csv';
        $file = fopen($filePath, "r");
        
        $this->em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $this->cityRepo = $this->em->getRepository(City::class);
        $this->urbanRepo = $this->em->getRepository(UrbanArea::class);
        $this->countryRepo = $this->em->getRepository(Country::class);

        while ($row = fgetcsv($file, 0, ';')) {
            $this->addCity(explode(',', $row[0]));
        }
        $this->em->flush();
        $output->writeln('Done!');
    }
    
    private function addCity($row)
    {        
        static $commit;
        
        if ($this->cityRepo->findOneByCode($row[1])) {
            return;
        }
        
        $area = $this->getUrbanArea(trim($row[3]), $row);
                
        $city = new City;
        $city
            ->setCode($row[1])
            ->setName(str_replace('%%', ',', $row[2]))
            ->setUrbanArea($area)
            ;
        
        $this->em->persist($city);
        
        if ($commit++ > 1000) {
            $this->em->flush();
            $commit = 0;
        }

    }
    
    private function getUrbanArea($code, $row)
    {
        $area = $this->urbanRepo->findOneByCode($code);
        
        if ($area) {
            return $area;
        }
        $countryCode = trim(preg_replace('/\d/', '', $code));
        $country =  $this->getCountry($countryCode, $row);
        
        $area = new UrbanArea;
        $area
            ->setCode($code)
            ->setName($row[4])
            ->setCountry($country)
            ;
        
        $this->em->persist($area);
        $this->em->flush();
        return $area;
    }
    
    private function getCountry($code, $row)
    {
        $country = $this->countryRepo->findOneByCode($code);
        
        if ($country) {
            return $country;
        }
        
        $country = new Country;
        $country
            ->setCode($code)
            ->setName($row[0])
            ;
        
        $this->em->persist($country);
        return $country;
    }
}
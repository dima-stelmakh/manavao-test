<?php

namespace Bundles\OptionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;


/**
 * AuthorType
 *
 * @ORM\Table(name="author_type")
 * @ORM\Entity(repositoryClass="Bundles\OptionBundle\Repository\AuthorTypeRepository")
 */
class AuthorType
{
    use ORMBehaviors\Translatable\Translatable;
    
    public function __toString()
    {
        return $this->getId() ? (string)$this->translate('en')->getName() : '-';
    }
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}

<?php

namespace Bundles\OptionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * IndustryTranslation
 *
 * @ORM\Table(name="industry_translation")
 * @ORM\Entity
 */
class IndustryTranslation
{
    
    use ORMBehaviors\Translatable\Translation;
    
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=1024)
     */
    private $name;

    /**
     * Set name
     *
     * @param string $name
     *
     * @return IndustryTranslation
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}

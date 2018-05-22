<?php

namespace Bundles\OptionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * InterestedInTranslation
 *
 * @ORM\Table(name="interested_in_translation")
 * @ORM\Entity
 */
class InterestedInTranslation
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
     * @return InterestedInTranslation
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

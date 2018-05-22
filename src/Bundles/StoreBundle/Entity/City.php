<?php

namespace Bundles\StoreBundle\Entity;

/**
 * City
 */
class City
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $code;
    
    /**
     * @var \Bundles\StoreBundle\Entity\UrbanArea
     */
    private $urbanArea;

    public function __toString() {
        return $this->name ? $this->name : 'New';
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return City
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

    /**
     * Set code
     *
     * @param string $code
     *
     * @return City
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set urbanArea
     *
     * @param \Bundles\StoreBundle\Entity\UrbanArea $urbanArea
     *
     * @return City
     */
    public function setUrbanArea(\Bundles\StoreBundle\Entity\UrbanArea $urbanArea = null)
    {
        $this->urbanArea = $urbanArea;

        return $this;
    }

    /**
     * Get urbanArea
     *
     * @return \Bundles\StoreBundle\Entity\UrbanArea
     */
    public function getUrbanArea()
    {
        return $this->urbanArea;
    }
}

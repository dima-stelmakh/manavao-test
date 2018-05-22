<?php

namespace Bundles\StoreBundle\Entity;

/**
 * Country
 */
class Country
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

    public function __toString()
    {
        return $this->name ? $this->name : 'New';
    }

    /**
     * Get id
     *
     * @return int
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
     * @return Country
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
     * @return Country
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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $urbanAreas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->urbanAreas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add urbanArea
     *
     * @param \Bundles\StoreBundle\Entity\UrbanArea $urbanArea
     *
     * @return Country
     */
    public function addUrbanArea(\Bundles\StoreBundle\Entity\UrbanArea $urbanArea)
    {
        $this->urbanAreas[] = $urbanArea;

        return $this;
    }

    /**
     * Remove urbanArea
     *
     * @param \Bundles\StoreBundle\Entity\UrbanArea $urbanArea
     */
    public function removeUrbanArea(\Bundles\StoreBundle\Entity\UrbanArea $urbanArea)
    {
        $this->urbanAreas->removeElement($urbanArea);
    }

    /**
     * Get urbanAreas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUrbanAreas()
    {
        return $this->urbanAreas;
    }
}

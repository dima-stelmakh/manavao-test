<?php

namespace Bundles\StoreBundle\Entity;

/**
 * UrbanArea
 */
class UrbanArea
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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $cities;

    /**
     * @var \Bundles\StoreBundle\Entity\Country
     */
    private $country;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $communities;

    private $region;

    private $code_sno;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cities = new \Doctrine\Common\Collections\ArrayCollection();
        $this->communities = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
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
     * @return UrbanArea
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
     * @return UrbanArea
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
     * Add city
     *
     * @param \Bundles\StoreBundle\Entity\City $city
     *
     * @return UrbanArea
     */
    public function addCity(\Bundles\StoreBundle\Entity\City $city)
    {
        $this->cities[] = $city;

        return $this;
    }

    /**
     * Remove city
     *
     * @param \Bundles\StoreBundle\Entity\City $city
     */
    public function removeCity(\Bundles\StoreBundle\Entity\City $city)
    {
        $this->cities->removeElement($city);
    }

    /**
     * Get cities
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCities()
    {
        return $this->cities;
    }

    /**
     * Add community
     *
     * @param \Bundles\StoreBundle\Entity\Community $community
     *
     * @return UrbanArea
     */
    public function addCommunity(\Bundles\StoreBundle\Entity\Community $community)
    {
        $this->communities[] = $community;

        return $this;
    }

    /**
     * Remove community
     *
     * @param \Bundles\StoreBundle\Entity\Community $community
     */
    public function removeCommunity(\Bundles\StoreBundle\Entity\Community $community)
    {
        $this->communities->removeElement($community);
    }

    /**
     * Get communities
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommunities()
    {
        return $this->communities;
    }

    /**
     * Set country
     *
     * @param \Bundles\StoreBundle\Entity\Country $country
     *
     * @return UrbanArea
     */
    public function setCountry(\Bundles\StoreBundle\Entity\Country $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return \Bundles\StoreBundle\Entity\Country
     */
    public function getCountry()
    {
        return $this->country;
    }
    /**
     * @var \Bundles\StoreBundle\Entity\Community
     */
    private $community;


    /**
     * Set community
     *
     * @param \Bundles\StoreBundle\Entity\Community $community
     *
     * @return UrbanArea
     */
    public function setCommunity(\Bundles\StoreBundle\Entity\Community $community = null)
    {
        $this->community = $community;

        return $this;
    }

    /**
     * Get community
     *
     * @return \Bundles\StoreBundle\Entity\Community
     */
    public function getCommunity()
    {
        return $this->community;
    }

    public function getRegion()
    {
        return $this->region;
    }

}

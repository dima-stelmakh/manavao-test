<?php

namespace Bundles\StoreBundle\Entity;

/**
 * EventPost
 */
class EventPost
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
     * @var \DateTime
     */
    private $endDate;

    /**
     * @var string
     */
    private $startDate;

    /**
     * @var string
     */
    private $link;

    /**
     * @var string
     */
    private $lat;


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
     * @return EventPost
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
     * Set endDate
     *
     * @param \DateTime $endDate
     *
     * @return EventPost
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set startDate
     *
     * @param string $startDate
     *
     * @return EventPost
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return string
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set link
     *
     * @param string $link
     *
     * @return EventPost
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set lat
     *
     * @param string $lat
     *
     * @return EventPost
     */
    public function setLat($lat)
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * Get lat
     *
     * @return string
     */
    public function getLat()
    {
        return $this->lat;
    }
    /**
     * @var \Bundles\StoreBundle\Entity\Post
     */
    private $post;

    /**
     * @var \Bundles\OptionBundle\Entity\Industry
     */
    private $industry;

    /**
     * @var \Bundles\OptionBundle\Entity\EventType
     */
    private $eventType;


    /**
     * Set post
     *
     * @param \Bundles\StoreBundle\Entity\Post $post
     *
     * @return EventPost
     */
    public function setPost(\Bundles\StoreBundle\Entity\Post $post = null)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return \Bundles\StoreBundle\Entity\Post
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Set industry
     *
     * @param \Bundles\OptionBundle\Entity\Industry $industry
     *
     * @return EventPost
     */
    public function setIndustry(\Bundles\OptionBundle\Entity\Industry $industry = null)
    {
        $this->industry = $industry;

        return $this;
    }

    /**
     * Get industry
     *
     * @return \Bundles\OptionBundle\Entity\Industry
     */
    public function getIndustry()
    {
        return $this->industry;
    }

    /**
     * Set eventType
     *
     * @param \Bundles\OptionBundle\Entity\EventType $eventType
     *
     * @return EventPost
     */
    public function setEventType(\Bundles\OptionBundle\Entity\EventType $eventType = null)
    {
        $this->eventType = $eventType;

        return $this;
    }

    /**
     * Get eventType
     *
     * @return \Bundles\OptionBundle\Entity\EventType
     */
    public function getEventType()
    {
        return $this->eventType;
    }
    /**
     * @var boolean
     */
    private $onlyToMeShow;

    /**
     * @var string
     */
    private $location;


    /**
     * Set onlyToMeShow
     *
     * @param boolean $onlyToMeShow
     *
     * @return EventPost
     */
    public function setOnlyToMeShow($onlyToMeShow)
    {
        $this->onlyToMeShow = $onlyToMeShow;

        return $this;
    }

    /**
     * Get onlyToMeShow
     *
     * @return boolean
     */
    public function getOnlyToMeShow()
    {
        return $this->onlyToMeShow;
    }

    /**
     * Set location
     *
     * @param string $location
     *
     * @return EventPost
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @var string
     */
    private $lng;


    /**
     * Set lng
     *
     * @param string $lng
     *
     * @return EventPost
     */
    public function setLng($lng)
    {
        $this->lng = $lng;

        return $this;
    }

    /**
     * Get lng
     *
     * @return string
     */
    public function getLng()
    {
        return $this->lng;
    }
}

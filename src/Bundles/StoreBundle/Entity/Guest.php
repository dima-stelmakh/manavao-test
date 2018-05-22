<?php

namespace Bundles\StoreBundle\Entity;

/**
 * Guest
 */
class Guest
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime;
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Guest
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    /**
     * @var \Bundles\UserBundle\Entity\User
     */
    private $user;

    /**
     * @var \Bundles\UserBundle\Entity\User
     */
    private $guest;


    /**
     * Set user
     *
     * @param \Bundles\UserBundle\Entity\User $user
     *
     * @return Guest
     */
    public function setUser(\Bundles\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Bundles\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set guest
     *
     * @param \Bundles\UserBundle\Entity\User $guest
     *
     * @return Guest
     */
    public function setGuest(\Bundles\UserBundle\Entity\User $guest = null)
    {
        $this->guest = $guest;

        return $this;
    }

    /**
     * Get guest
     *
     * @return \Bundles\UserBundle\Entity\User
     */
    public function getGuest()
    {
        return $this->guest;
    }
}

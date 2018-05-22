<?php

namespace Bundles\StoreBundle\Entity;

/**
 * Friend
 */
class Friend
{
    const STATUS_REQUEST = 1;
    const STATUS_CONFIRMED = 2;
        
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $status;


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
     * Set status
     *
     * @param integer $status
     *
     * @return Friend
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }
    /**
     * @var \Bundles\UserBundle\Entity\User
     */
    private $user;

    /**
     * @var \Bundles\UserBundle\Entity\User
     */
    private $friend;


    /**
     * Set user
     *
     * @param \Bundles\UserBundle\Entity\User $user
     *
     * @return Friend
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
     * Set friend
     *
     * @param \Bundles\UserBundle\Entity\User $friend
     *
     * @return Friend
     */
    public function setFriend(\Bundles\UserBundle\Entity\User $friend = null)
    {
        $this->friend = $friend;

        return $this;
    }

    /**
     * Get friend
     *
     * @return \Bundles\UserBundle\Entity\User
     */
    public function getFriend()
    {
        return $this->friend;
    }
}

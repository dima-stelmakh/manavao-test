<?php

namespace Bundles\StoreBundle\Entity;

/**
 * Notification
 */
class Notification
{
    const TYPE_USER_JOINED_TO_COMMUNITY = 1;
    const TYPE_POSTED_IN_COMMUNITY = 2;
    const TYPE_SHARE_MY_POST = 3;
    const TYPE_LIKE_MY_POST = 4;
      
    public function __construct()
    {
        $this->createdAt = new \DateTime;
    }
    
    /**
     * @var integer
     */
    private $id;

    /**
     * @var boolean
     */
    private $new = true;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var integer
     */
    private $noteType;

    /**
     * @var \Bundles\UserBundle\Entity\User
     */
    private $user;

    /**
     * @var \Bundles\UserBundle\Entity\User
     */
    private $aboutUser;

    /**
     * @var \Bundles\StoreBundle\Entity\Community
     */
    private $community;

    /**
     * @var \Bundles\StoreBundle\Entity\Post
     */
    private $post;


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
     * Set new
     *
     * @param boolean $new
     *
     * @return Notification
     */
    public function setNew($new)
    {
        $this->new = $new;

        return $this;
    }

    /**
     * Get new
     *
     * @return boolean
     */
    public function getNew()
    {
        return $this->new;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Notification
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
     * Set noteType
     *
     * @param integer $noteType
     *
     * @return Notification
     */
    public function setNoteType($noteType)
    {
        $this->noteType = $noteType;

        return $this;
    }

    /**
     * Get noteType
     *
     * @return integer
     */
    public function getNoteType()
    {
        return $this->noteType;
    }

    /**
     * Set user
     *
     * @param \Bundles\UserBundle\Entity\User $user
     *
     * @return Notification
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
     * Set aboutUser
     *
     * @param \Bundles\UserBundle\Entity\User $aboutUser
     *
     * @return Notification
     */
    public function setAboutUser(\Bundles\UserBundle\Entity\User $aboutUser = null)
    {
        $this->aboutUser = $aboutUser;

        return $this;
    }

    /**
     * Get aboutUser
     *
     * @return \Bundles\UserBundle\Entity\User
     */
    public function getAboutUser()
    {
        return $this->aboutUser;
    }

    /**
     * Set community
     *
     * @param \Bundles\StoreBundle\Entity\Community $community
     *
     * @return Notification
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

    /**
     * Set post
     *
     * @param \Bundles\StoreBundle\Entity\Post $post
     *
     * @return Notification
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
}

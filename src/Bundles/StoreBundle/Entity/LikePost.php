<?php

namespace Bundles\StoreBundle\Entity;

/**
 * LikePost
 */
class LikePost
{
    /**
     * @var int
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
    /**
     * @var \Bundles\UserBundle\Entity\User
     */
    private $user;

    /**
     * @var \Bundles\StoreBundle\Entity\Post
     */
    private $post;


    /**
     * Set user
     *
     * @param \Bundles\UserBundle\Entity\User $user
     *
     * @return LikePost
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
     * Set post
     *
     * @param \Bundles\StoreBundle\Entity\Post $post
     *
     * @return LikePost
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

<?php

namespace Bundles\StoreBundle\Entity;

/**
 * UpdatePost
 */
class UpdatePost
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
     * @var \Bundles\StoreBundle\Entity\Post
     */
    private $post;

    /**
     * @var \Bundles\OptionBundle\Entity\Industry
     */
    private $industry;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $communities;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->communities = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set post
     *
     * @param \Bundles\StoreBundle\Entity\Post $post
     *
     * @return UpdatePost
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
     * @return UpdatePost
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
     * @var \Bundles\OptionBundle\Entity\PostCategory
     */
    private $postCategory;


    /**
     * Set postCategory
     *
     * @param \Bundles\OptionBundle\Entity\PostCategory $postCategory
     *
     * @return UpdatePost
     */
    public function setPostCategory(\Bundles\OptionBundle\Entity\PostCategory $postCategory = null)
    {
        $this->postCategory = $postCategory;

        return $this;
    }

    /**
     * Get postCategory
     *
     * @return \Bundles\OptionBundle\Entity\PostCategory
     */
    public function getPostCategory()
    {
        return $this->postCategory;
    }
}

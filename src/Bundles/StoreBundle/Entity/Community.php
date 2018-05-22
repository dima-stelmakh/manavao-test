<?php

namespace Bundles\StoreBundle\Entity;

/**
 * Community
 */
class Community
{
    use \Bundles\StoreBundle\Component\City;
    
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;
    
    /**
     * @var \Bundles\StoreBundle\Entity\UrbanArea
     */
    private $area;
    
    /**
     * @var string
     */
    private $overview;

    /**
     * @var \Bundles\ImageBundle\Entity\Image
     */
    private $image;

    /**
     * @var \Bundles\ImageBundle\Entity\Image
     */
    private $icon;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $post;

    private $enable;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
        $this->post = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    public function __toString()
    {
        return $this->name ? $this->name : 'New';
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $users;

    public function getCity()
    {
        return $this->getArea()->getCountry()->getName() . ', '. $this->getArea()->getName();
    }

    /**
     * Get icon
     *
     * @return \Bundles\ImageBundle\Entity\Image
     */
    public function getIconPath()
    {
        if ($this->icon) {
            return $this->icon->getSrc();   
        }
        
        $webPath = '/uploads/images/single_image/'. strtolower($this->getArea()->getName()).'.png';
        $file = __DIR__. '/../../../../web' . $webPath;
        
        if (file_exists($file)) {
            return $webPath;
        }
        
        return '/assets/img/cities/default.png';
    }
    
    /**
     * Set area
     *
     * @param \Bundles\StoreBundle\Entity\UrbanArea $area
     *
     * @return Community
     */
    public function setArea(\Bundles\StoreBundle\Entity\UrbanArea $area = null)
    {
        $this->area = $area;
        $this->setLocation();
        return $this;
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
     * @return Community
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
     * Set overview
     *
     * @param string $overview
     *
     * @return Community
     */
    public function setOverview($overview)
    {
        $this->overview = $overview;

        return $this;
    }

    /**
     * Get overview
     *
     * @return string
     */
    public function getOverview()
    {
        return $this->overview;
    }

    /**
     * Get area
     *
     * @return \Bundles\StoreBundle\Entity\UrbanArea
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * Set image
     *
     * @param \Bundles\ImageBundle\Entity\Image $image
     *
     * @return Community
     */
    public function setImage(\Bundles\ImageBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \Bundles\ImageBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set icon
     *
     * @param \Bundles\ImageBundle\Entity\Image $icon
     *
     * @return Community
     */
    public function setIcon(\Bundles\ImageBundle\Entity\Image $icon = null)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get icon
     *
     * @return \Bundles\ImageBundle\Entity\Image
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Add user
     *
     * @param \Bundles\UserBundle\Entity\User $user
     *
     * @return Community
     */
    public function addUser(\Bundles\UserBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \Bundles\UserBundle\Entity\User $user
     */
    public function removeUser(\Bundles\UserBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Add post
     *
     * @param \Bundles\StoreBundle\Entity\Post $post
     *
     * @return Community
     */
    public function addPost(\Bundles\StoreBundle\Entity\Post $post)
    {
        $this->post[] = $post;

        return $this;
    }

    /**
     * Remove post
     *
     * @param \Bundles\StoreBundle\Entity\Post $post
     */
    public function removePost(\Bundles\StoreBundle\Entity\Post $post)
    {
        $this->post->removeElement($post);
    }

    /**
     * Get post
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPost()
    {
        return $this->post;
    }
}

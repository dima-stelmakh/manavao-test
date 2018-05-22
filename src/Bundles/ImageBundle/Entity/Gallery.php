<?php

namespace Bundles\ImageBundle\Entity;

/**
 * Gallery
 */
class Gallery
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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $images;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add image
     *
     * @param \Bundles\ImageBundle\Entity\GalleryImage $image
     *
     * @return Gallery
     */
    public function addImage(\Bundles\ImageBundle\Entity\GalleryImage $image)
    {
        $this->images[] = $image;

        return $this;
    }

    /**
     * Remove image
     *
     * @param \Bundles\ImageBundle\Entity\GalleryImage $image
     */
    public function removeImage(\Bundles\ImageBundle\Entity\GalleryImage $image)
    {
        $this->images->removeElement($image);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }
}

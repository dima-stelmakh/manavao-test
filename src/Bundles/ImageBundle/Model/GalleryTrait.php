<?php

namespace Bundles\ImageBundle\Model;

/**
 * Gallery
 */
trait GalleryTrait
{
    /**
     * @var \Bundles\ImageBundle\Entity\Gallery
     */
    private $gallery;

    /**
     * Set gallery
     *
     * @param \Bundles\ImageBundle\Entity\Gallery $gallery
     *
     * @return Advert
     */
    public function setGallery(\Bundles\ImageBundle\Entity\Gallery $gallery = null)
    {
        $this->gallery = $gallery;

        return $this;
    }

    /**
     * Get gallery
     *
     * @return \Bundles\ImageBundle\Entity\Gallery
     */
    public function getGallery()
    {
        return $this->gallery;
    }
    
    public function getImage()
    {
        if (!$this->gallery) {
            return $this->getNoPhoto();
        }
        $image = $this->gallery->getImages()->first();
        if (!$image) {
            return $this->getNoPhoto();
        }
        return $image;
    }
    
    private function getNoPhoto()
    {
        $image = new \stdClass;
        $image->src = '/admin/production/images/img.jpg';
        return $image;
    }
    
    public function getImages()
    {
        if (!$this->gallery) {
            return [];
        }
        return $this->gallery->getImages();
    }
    
}

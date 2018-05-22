<?php

namespace Bundles\ImageBundle\Entity;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Bundles\ImageBundle\Model\ImageTrait;

/**
 * GalleryImage
 */
class GalleryImage
{
    use ImageTrait;
        
    const FOLDER_PATH = 'uploads/images/gallery';
    
    /**
     * @var int
     */
    private $id;

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw when displaying uploaded doc/image in the view.
        return self::FOLDER_PATH;
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
     * @var \Bundles\ImageBundle\Entity\Gallery
     */
    private $gallery;


    /**
     * Set gallery
     *
     * @param \Bundles\ImageBundle\Entity\Gallery $gallery
     *
     * @return GalleryImage
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
}

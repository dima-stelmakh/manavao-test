<?php

namespace Bundles\ImageBundle\Model;

/**
 * Image
 */
trait Imageable
{
        /**
     * @var \Bundles\ImageBundle\Entity\Image
     */
    private $image;


    /**
     * Set image
     *
     * @param \Bundles\ImageBundle\Entity\Image $image
     *
     * @return Realtor
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
        $image = $this->image;

        if (!$image) {
           $image = new \stdClass;
           $image->src = '/assets/img/noname.png';
        }
        return $image;
    }

}

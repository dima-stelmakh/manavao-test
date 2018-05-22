<?php

namespace Bundles\ImageBundle\Service;

use Bundles\ImageBundle\Entity\Gallery;
use Bundles\ImageBundle\Entity\GalleryImage;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Bundles\ImageBundle\Entity\Image;


class ImageManager
{
    private $em;
    
    public function __construct($em)
    {   
        $this->em = $em;
    }

    public function addImage($item, UploadedFile $file)
    {
        $gallery = $item->getGallery();
        if (!$gallery) {
            $gallery = new Gallery;
            $this->em->persist($gallery);
            $item->setGallery($gallery);
        }
        $image = new GalleryImage;
        $image->setFile($file);
        $image->setGallery($gallery);
        
        $this->em->persist($image);
        $this->em->flush();
                
    }
    
    public function setImage($item, UploadedFile $file, $field = 'image')
    {
        $fieldName = lcfirst($field);
        $getMethod = 'get' . $fieldName;
        $setMethod = 'set' . $fieldName;
        
        $image = $item->$getMethod();
        if (!$image || $image instanceof \stdClass) {
            $image = new Image;
            $item->$setMethod($image);
            $this->em->persist($image);
        }
        $image->setFile($file)->upload();       
        $this->em->flush();
        //dump($image); die;
        return $item;       
    }
    
    public function setImageGlobal($item, $path, $field = 'image')
    {
        $fieldName = lcfirst($field);
        $getMethod = 'get' . $fieldName;
        $setMethod = 'set' . $fieldName;
        
        $image = $item->$getMethod();
        if (!$image || $image instanceof \stdClass) {
            $image = new Image;
            $item->$setMethod($image);
            $this->em->persist($image);
        }
        $image->setPath($path);
        $this->em->flush();
        return $item;       
    }
    
    public function addImages($item, $files)
    {
        foreach ($files as $file) {
            $this->addImage($item, $file);
        }
    }
    
}

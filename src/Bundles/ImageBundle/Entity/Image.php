<?php

namespace Bundles\ImageBundle\Entity;

use Bundles\ImageBundle\Model\ImageTrait;

/**
 * Image
 */
class Image
{
    use ImageTrait;
        
    const FOLDER_PATH = 'uploads/images/single_image';
    
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

}

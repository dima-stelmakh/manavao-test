<?php

namespace Bundles\ImageBundle\Model;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Image
 */
trait ImageTrait
{
    /**
     * @var string
     */
    private $path;
    
    /**
     * Unmapped property to handle file uploads
     */
    private $file;

    public function __toString()
    {
        return $this->id?(string)$this->id:'New';
    }
    
    /**
     * Set path
     *
     * @param string $path
     *
     * @return Image
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
    
    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
        return $this;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }
    
    public function getSrc()
    {
        if (substr($this->path, 0, 4) == 'http') {
            return $this->path;
        }
        return $this->getWebPath();
    }
    
    /**
     * Manages the copying of the file to the relevant place on the server
     */
    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            return;
        }

        $folderPath = __DIR__ . '/../../../../web/'. self::FOLDER_PATH;
        // move takes the target directory and target path as params
        $fileName = uniqid().'.'.$this->getFile()->getClientOriginalExtension();
        
        $this->getFile()->move(
            $folderPath,
            $fileName
        );

        // set the path property to the path where you've saved the file
        $this->path = $fileName;

        // clean up the file property as you won't need it anymore
        $this->setFile(null);
    }

    public function lifecycleFileUpload() {
        $this->upload();
    }
    
    public function lifecycleFileRemove()
    {
        $this->removeFile();
    }

    public function removeFile()
    {  
        $file_path = $this->getAbsolutePath();
        if(file_exists($file_path)) {
            unlink($file_path);  
        }
    }

    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return 'https://manavao.s3.eu-west-3.amazonaws.com/uploads/image/path/'.$this->id.'/'.$this->path;
        // return null === $this->path ? null : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded documents should be saved
        return __DIR__.'/../../../../../web/'.$this->getUploadDir();
    }
    
}

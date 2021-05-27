<?php

class Images
{
    private $idImage;
    private $dateCreation;
    private $name;
    private $fileExtension;


    /**
     * Get the value of idImage
     */
    public function getIdImage()
    {
        return $this->idImage;
    }

    /**
     * Set the value of idImage
     *
     * @return  self
     */
    public function setIdImage($idImage)
    {
        $this->idImage = $idImage;

        return $this;
    }

    /**
     * Get the value of dateCreation
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set the value of dateCreation
     *
     * @return  self
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of fileExtension
     */
    public function getFileExtension()
    {
        return $this->fileExtension;
    }

    /**
     * Set the value of fileExtension
     *
     * @return  self
     */
    public function setFileExtension($fileExtension)
    {
        $this->fileExtension = $fileExtension;

        return $this;
    }

    public function setImagesFromArray($images)
    {
        foreach ($images as $key => $value) {

            $this->$key = $value;
        }
    }
}

<?php

namespace HabanaTech\BusinessModel\ORM\Models;

use HabanaTech\BusinessModel\ORM\Entity\Image;
use Vich\UploaderBundle\Form\Type\VichFileType;

class SingleImageFromGallery
{
    private $imageFieldAction;
    private $galleryImage;
    private $updateImage;
    private $uploadNewImage;

    /**
     * @return mixed
     */
    public function getImageFieldAction(): ?string
    {
        return $this->imageFieldAction;
    }

    /**
     * @param mixed $imageFieldAction
     * @return SingleImageFromGallery
     */
    public function imageFieldAction($imageFieldAction = null)
    {
        $this->imageFieldAction = $imageFieldAction;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGalleryImage(): ?Image
    {
        return $this->galleryImage;
    }

    /**
     * @param mixed $galleryImage
     * @return SingleImageFromGallery
     */
    public function setGalleryImage(?Image $galleryImage)
    {
        $this->galleryImage = $galleryImage;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUpdateImage(): ?Image
    {
        return $this->updateImage;
    }

    /**
     * @param mixed $updateImage
     * @return SingleImageFromGallery
     */
    public function setUpdateImage(?Image $updateImage)
    {
        $this->updateImage = $updateImage;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUploadNewImage(): ?Image
    {
        return $this->uploadNewImage;
    }

    /**
     * @param mixed $uploadNewImage
     * @return SingleImageFromGallery
     */
    public function setUploadNewImage(?Image $uploadNewImage)
    {
        $this->uploadNewImage = $uploadNewImage;
        return $this;
    }

    public function isUpdateImage(): bool
    {
        return $this->imageFieldAction === 'updateImage' && $this->updateImage instanceof Image;
    }

    public function isFromGallery(): bool
    {
        return $this->imageFieldAction === 'fromGallery' &&  $this->galleryImage instanceof Image;
    }

    public function isUploadNewImage(): bool
    {
        return $this->imageFieldAction === 'uploadNewImage' && $this->uploadNewImage instanceof Image;
    }


    public function getLastImage(): Image
    {
        if ($this->isUpdateImage()) {
            return $this->getUpdateImage();
        }
        if ($this->isFromGallery()) {
            return $this->getGalleryImage();
        }
        return $this->getUploadNewImage();
    }
}

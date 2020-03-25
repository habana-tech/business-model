<?php

namespace HabanaTech\BusinessModel\ORM\Traits;

use HabanaTech\BusinessModel\ORM\Models\SingleImageFromGallery;
use HabanaTech\BusinessModel\ORM\Entity\Image;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Image
 */
trait ImageFieldTrait
{

    private $imageField;

    /**
     * @ORM\ManyToOne(targetEntity="HabanaTech\BusinessModel\ORM\Entity\Image", cascade={"persist"} )
     * @ORM\JoinColumn(nullable=true,  onDelete="SET NULL")
     */
    private $image;

    public function getImage():? Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function hasImage(): bool
    {
        return ($this->image instanceof Image && $this->image->getImageName() && $this->image->getImageName() !== 'no-image' );
    }

    public function uploadImage(): void
    {
        return;
    }


    public function getUploadImage()
    {
        return $this->image;
    }

    public function getUpdateImage()
    {
        return $this->image;
    }
    public function setUpdateImage($image = null): void
    {

    }

    public function  uploadNewImage($image = null): void
    {
        return null;

    }


    private $galleryImage;
    public function setGalleryImage(Image $image): void
    {
        $this->galleryImage = $image;
    }

    public function getGalleryImage(): ?Image
    {
        return $this->getImage();
    }

    private $imageFieldAction;

    /**
     * @return mixed
     */
    public function getImageFieldAction()
    {
        return $this->imageFieldAction;
    }

    /**
     * @param mixed $imageFieldAction
     * @return ImageFieldTrait
     */
    public function setImageFieldAction($imageFieldAction)
    {
        $this->imageFieldAction = $imageFieldAction;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getImageField(): SingleImageFromGallery
    {
        if($this->imageField === null) {
            $this->imageField = new SingleImageFromGallery();
        }
        return $this->imageField;
    }

    /**
     * @param mixed $imageField
     * @return ImageFieldTrait
     */
    public function setImageField($imageField)
    {
        $this->imageField = $imageField;
        return $this;
    }



}

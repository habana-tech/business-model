<?php


namespace HabanaTech\BusinessModel\ORM\Traits;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use HabanaTech\BusinessModel\ORM\Entity\Image;

trait GalleryFieldTrait
{

    /**
     * @ORM\ManyToMany(targetEntity="HabanaTech\BusinessModel\ORM\Entity\Image", cascade={"persist"})
     */
    private $gallery;

    private $uploadedImages;

    /**
     * @return mixed
     */
    public function getUploadedImages(): Collection
    {
        if($this->uploadedImages === null) {
            $this->uploadedImages = new ArrayCollection();
        }
        return $this->uploadedImages;
    }

    /**
     * @param mixed $uploadedImages
     */
    public function setUploadedImages($uploadedImages): void
    {
        $this->uploadedImages = $uploadedImages;
    }


    /**
     * @return Collection|Image[]
     */
    public function getGallery(): Collection
    {
        return $this->gallery;
    }

    public function addGallery(Image $gallery): self
    {
        if (!$this->gallery->contains($gallery)) {
            $this->gallery[] = $gallery;
        }

        return $this;
    }

    public function removeGallery(Image $gallery): self
    {
        if ($this->gallery->contains($gallery)) {
            $this->gallery->removeElement($gallery);
        }

        return $this;
    }


}
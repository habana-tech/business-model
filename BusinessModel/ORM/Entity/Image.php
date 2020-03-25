<?php

namespace HabanaTech\BusinessModel\ORM\Entity;

use HabanaTech\BusinessModel\ORM\Fields\Timestampable;
use HabanaTech\BusinessModel\Services\ImageBase64ThumbCreator;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="HabanaTech\BusinessModel\ORM\Repository\ImageRepository")
 * @Vich\Uploadable()
 */
class Image
{
    use Timestampable;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;


    /**
    * @Vich\UploadableField(mapping="images", fileNameProperty="imageName", size="imageSize")
    */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=180, nullable=true)
     */
    private string $imageName;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private int $imageSize;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private string $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private string $base64;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImagePath(): string
    {
        return 'uploads/images/' . $this->getImageName();
    }

    public function getImageName(): ?string
    {
        return $this->imageName ?? 'no-image';
    }

    public function setImageName(string $imageName = null): self
    {
        $this->imageName = $imageName;

        return $this;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    public function setImageSize(int $imageSize = null): self
    {
        $this->imageSize = $imageSize;

        return $this;
    }

    /**
     * @return File
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }


    /**
     * @param File|null $file
     * @return $this
     * @throws Exception
     */
    public function setImageFile(?File $file = null): self
    {
        $this->imageFile = $file;
        if (null !== $file) {
            $base64Converter = new ImageBase64ThumbCreator($file->getRealPath(), false);
            $this->setBase64($base64Converter->getBase64data());
            $this->updatedAt = new DateTimeImmutable();
            if (!$this->description && $file->getFilename()) {
                $this->description = substr(basename($file->getClientOriginalName()), 0, -4);
            }
        }
        return $this;
    }

    public function __toString()
    {
        if($this->description !== null) {
            return $this->description;
        }
        if(($name = $this->getImageName()) && $name !== null) {
            return (string)$name;
        }

        return '';
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getBase64(): ?string
    {
        return $this->base64;
    }

    public function setBase64(?string $base64): self
    {
        $this->base64 = $base64;

        return $this;
    }


    /**
     * @Assert\Callback
     * @param ExecutionContextInterface $context
     */
    public function validate(ExecutionContextInterface $context): void
    {
        if (
            ! in_array($this->imageFile->getMimeType(), array(
            'image/jpeg',
            'image/gif',
            'image/png',
            'image/svg+xml',
            'image/svg',

            ))
        ) {
            $context
                ->buildViolation('Wrong file type (jpg,gif,png,svg)')
                ->atPath('fileName')
                ->addViolation()
            ;
        }
    }
}

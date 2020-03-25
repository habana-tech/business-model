<?php

namespace HabanaTech\BusinessModel\ORM\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use HabanaTech\BusinessModel\ORM\Fields\Timestampable;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use HabanaTech\BusinessModel\ORM\Traits\ActiveFieldTrait;
use HabanaTech\BusinessModel\ORM\Traits\PriorityFieldTrait;

/**
 * @ORM\Entity(repositoryClass="HabanaTech\BusinessModel\ORM\Repository\FilterTagRepository")
 * @Vich\Uploadable()
 */
class FilterTag
{
    use ActiveFieldTrait;
    use PriorityFieldTrait;
    use Timestampable;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $title;


    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private  bool $pinned;

    /**
     * @ORM\Column(type="string", length=180)
     */
    private string $iconName;

    /**
    * @Vich\UploadableField(mapping="tags_icons", fileNameProperty="iconName")
    */
    private $iconFile;

    public function __construct()
    {
        $this->active = true;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }


    public function __toString(): string
    {
        return $this->title;
    }


    public function getPinned(): ?bool
    {
        return $this->pinned;
    }

    public function setPinned(?bool $pinned): self
    {
        $this->pinned = $pinned;

        return $this;
    }


    public function getNameFieldValue(): ?string
    {
        return $this->title;
    }


    /**
     * @return mixed
     */
    public function getIconFile()
    {
        return $this->iconFile;
    }

    /**
     * @param mixed $iconFile
     * @return FilterTag
     * @throws Exception
     */
    public function setIconFile($iconFile): FilterTag
    {
        $this->iconFile = $iconFile;
        if ($iconFile) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new DateTime('now');
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIconName()
    {
        return $this->iconName;
    }

    /**
     * @param mixed $icon
     * @return FilterTag
     */
    public function setIconName($icon): FilterTag
    {
        $this->iconName = $icon;
        return $this;
    }


    /**
     * @Assert\Callback
     * @param ExecutionContextInterface $context
     */
    public function validate(ExecutionContextInterface $context): void
    {
        if (
            ! in_array($this->iconFile->getMimeType(), array(
            'image/svg+xml',
            'image/svg',
            'image/png',

            ))
        ) {
            $context
                ->buildViolation('Wrong file type (svg, png)')
                ->atPath('iconName')
                ->addViolation()
            ;
        }
    }
}

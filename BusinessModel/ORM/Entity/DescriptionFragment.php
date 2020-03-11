<?php

namespace HabanaTech\BusinessModel\ORM\Entity;

use HabanaTech\BusinessModel\ORM\Interfaces\ImageFieldInterface;
use HabanaTech\BusinessModel\ORM\Traits\ImageFieldTrait;
use HabanaTech\BusinessModel\ORM\Traits\MetadataFieldTrait;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DescriptionFragmentRepository")
 * @Vich\Uploadable()
 */
class DescriptionFragment implements ImageFieldInterface
{
    use ImageFieldTrait;
    use MetadataFieldTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}

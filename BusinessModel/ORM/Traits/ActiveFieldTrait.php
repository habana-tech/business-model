<?php


namespace HabanaTech\BusinessModel\ORM\Traits;


trait ActiveFieldTrait
{

      /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private bool $active;


    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(?bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function toggleActive(): self
    {
        $this->active = !$this->active;

        return $this;
    }


}
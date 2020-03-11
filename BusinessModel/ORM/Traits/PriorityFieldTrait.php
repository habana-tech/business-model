<?php


namespace HabanaTech\BusinessModel\ORM\Traits;


trait PriorityFieldTrait
{

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $priority;


    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(?int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

}
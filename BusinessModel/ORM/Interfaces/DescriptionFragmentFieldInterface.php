<?php


namespace HabanaTech\BusinessModel\ORM\Interfaces;


use HabanaTech\BusinessModel\ORM\DescriptionFragment;
use Doctrine\Common\Collections\Collection;

interface DescriptionFragmentFieldInterface
{
    /**
     * @return Collection|DescriptionFragment[]
     */
    public function getDescriptionFragments():? Collection;
}
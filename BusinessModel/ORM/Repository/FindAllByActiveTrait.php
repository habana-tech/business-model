<?php

namespace HabanaTech\BusinessModel\ORM\Repository;

trait FindAllByActiveTrait
{

    /**
     * Finds all actives entities in the repository.
     *
     * @return array The entities.
     */
    public function findAllActive(): array
    {
        return $this->findBy(['active' => true]);
    }
}

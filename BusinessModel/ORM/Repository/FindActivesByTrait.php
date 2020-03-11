<?php

namespace HabanaTech\BusinessModel\ORM\Repository;

trait FindActivesByTrait
{

     /**
     * Finds actives entities by a set of criteria.
     *
     * @param array      $criteria
     * @param array|null $orderBy
     * @param int|null   $limit
     * @param int|null   $offset
     *
     * @return array The objects.
     */
    public function findActivesBy(array $criteria, array $orderBy = null, $limit = null, $offset = null): array
    {
        $persister = $this->_em->getUnitOfWork()->getEntityPersister($this->_entityName);

        $criteria['active'] = true;

        return $persister->loadAll($criteria, $orderBy, $limit, $offset);
    }
}

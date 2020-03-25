<?php
/**
 * Created by PhpStorm.
 * User: jo
 * Date: 11/19/2019
 * Time: 10:33 AM
 */

namespace HabanaTech\BusinessModel\ORM\Traits;


trait UniqueIdPropertyTrait {

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    protected $uniqueId;

    /**
     * @return mixed
     */
    public function getUniqueId()
    {
        return $this->uniqueId;
    }

    /**
     * @param string $prefix
     */
    public function setUniqueId(string $prefix = ''): void
    {
        $this->uniqueId = uniqid($prefix, true);
    }


}
<?php

/*
 * This file is part of the KnpDoctrineBehaviors package.
 *
 * (c) KnpLabs <http://knplabs.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HabanaTech\BusinessModel\ORM\Fields\Timestampable;

/**
 * Timestampable trait.
 *
 * Should be used inside entity, that needs to be timestamped.
 */
trait TimestampableProperties
{
    protected $createdAt;

    protected $updatedAt;
}

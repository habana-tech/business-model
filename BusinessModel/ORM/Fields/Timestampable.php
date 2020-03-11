<?php

/*
 * This file is part of the KnpDoctrineBehaviors package.
 *
 * (c) KnpLabs <http://knplabs.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HabanaTech\BusinessModel\ORM\Fields;

use HabanaTech\BusinessModel\ORM\Fields\Timestampable\TimestampableMethods;
use HabanaTech\BusinessModel\ORM\Fields\Timestampable\TimestampableProperties;

/**
 * Timestampable trait.
 *
 * Should be used inside entity, that needs to be timestamped.
 */
trait Timestampable
{
    use TimestampableProperties,
        TimestampableMethods
    ;
}

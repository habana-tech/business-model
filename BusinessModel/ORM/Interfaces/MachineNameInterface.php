<?php

namespace HabanaTech\BusinessModel\ORM\Interfaces;


/**
 * Machinename Interface
 */
interface MachineNameInterface
{
    public function setMachineName($machineName);

    public function getMachineName(): string;

    public function generateMachineName();

    public function getNameFieldValue():? string;

}

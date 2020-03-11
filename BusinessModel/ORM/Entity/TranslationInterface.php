<?php

declare(strict_types=1);


namespace HabanaTech\BusinessModel\ORM\Entity;

interface TranslationInterface
{
    public function setLocale(string $locale): void;

    public function getLocale(): string;
}

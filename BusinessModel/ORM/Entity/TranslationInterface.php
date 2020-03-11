<?php

declare(strict_types=1);


namespace App\Model\ORM\Entity;

interface TranslationInterface
{
    public function setLocale(string $locale): void;

    public function getLocale(): string;
}

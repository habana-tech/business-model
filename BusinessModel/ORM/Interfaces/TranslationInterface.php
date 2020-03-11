<?php


namespace App\Model\ORM\Interfaces;


interface TranslationInterface
{

    public function setLocale(string $locale): void;

    public function getLocale(): string;

    public function isEmpty(): bool;
}
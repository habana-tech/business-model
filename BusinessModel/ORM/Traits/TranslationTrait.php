<?php


namespace App\Model\ORM\Traits;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Model\ORM\Interfaces\TranslationInterface;

trait TranslationTrait
{


    /**
     * currentLocale is a non persisted field configured during postLoad event
     * @var string|null
     */
    protected $currentLocale;

    /**
     * @var string
     */
    protected $defaultLocale = 'en';


    /**
     * @var string
     */
    protected $locale;

    public function setLocale(string $locale): void
    {
        $this->locale = $locale;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * @return Collection|TranslationInterface[]
     */
    public function getTranslations()
    {
        // initialize collection, usually in ctor
        if (isset($this->metadata['translations']) === false) {
            $this->metadata['translations'] = [];
        }

        return $this->metadata['translations'];
    }


    public function setTranslations($translations): void
    {
        $this->__set('translations', $translations);
    }

    public function updateTranslations(): void
    {
        $this->__set('translations', $this->getTranslations());
    }

    /**
     * Returns translation for specific locale (creates new one if doesn't exists).
     * If requested translation doesn't exist, it will first try to fallback default locale
     * If any translation doesn't exist, it will be added to newTranslations collection.
     * In order to persist new translations, call mergeNewTranslations method, before flush
     *
     * @param string $locale The locale (en, ru, fr) | null If null, will try with current locale
     */
    public function translate(?string $locale = null, bool $fallbackToDefault = true): TranslationInterface
    {
        return $this->doTranslate($locale, $fallbackToDefault);
    }

    public function setCurrentLocale(string $locale): void
    {
        $this->currentLocale = $locale;
    }

    public function getCurrentLocale(): string
    {
        return $this->currentLocale ?: $this->getDefaultLocale();
    }

    /**
     * @param mixed $locale the default locale
     */
    public function setDefaultLocale($locale): void
    {
        $this->defaultLocale = $locale;
    }

    public function getDefaultLocale(): string
    {
        return $this->defaultLocale;
    }


    /**
     * Returns translation for specific locale (creates new one if doesn't exists).
     * If requested translation doesn't exist, it will first try to fallback default locale
     * If any translation doesn't exist, it will be added to newTranslations collection.
     * In order to persist new translations, call mergeNewTranslations method, before flush
     *
     * @param string $locale The locale (en, ru, fr) | null If null, will try with current locale
     */
    protected function doTranslate(?string $locale = null, bool $fallbackToDefault = true): TranslationInterface
    {
        if ($locale === null) {
            $locale = $this->getCurrentLocale();
        }

        $translation = $this->findTranslationByLocale($locale);
        if ($translation and ! $translation->isEmpty()) {
            return $translation;
        }

        if ($fallbackToDefault) {
            $fallbackLocale = $this->computeFallbackLocale($locale);

            if ($fallbackLocale) {
                $translation = $this->findTranslationByLocale($fallbackLocale);
                if ($translation) {
                    return $translation;
                }
            }

            $defaultTranslation = $this->findTranslationByLocale($this->getDefaultLocale(), false);
            if ($defaultTranslation) {
                return $defaultTranslation;
            }
        }

        if ($translation) {
            return $translation;
        }

//        $class = static::getTranslationEntityClass();
//
//        /** @var TranslationInterface $translation */
//        $translation = new $class();
//        $translation->setLocale($locale);
//
//        $this->getNewTranslations()->set((string) $translation->getLocale(), $translation);
//        $translation->setTranslatable($this);
//
//        return $translation;
    }

    /**
     * An extra feature allows you to proxy translated fields of a translatable entity.
     *
     * @return mixed The translated value of the field for current locale
     */
    protected function proxyCurrentLocaleTranslation(string $method, array $arguments = [])
    {
        // allow $entity->name call $entity->getName() in templates
        if (! method_exists(self::getTranslationEntityClass(), $method)) {
            $method = 'get' . ucfirst($method);
        }

        $translation = $this->translate($this->getCurrentLocale());

        return call_user_func_array([$translation, $method], $arguments);
    }

    /**
     * Finds specific translation in collection by its locale.
     */
    protected function findTranslationByLocale(string $locale, bool $withNewTranslations = true): ?TranslationInterface
    {
        $translation = $this->getTranslations()->get($locale);

        if ($translation) {
            return $translation;
        }

        if ($withNewTranslations) {
            return $this->getNewTranslations()->get($locale);
        }

        return null;
    }

    /**
     * @return false|string
     */
    protected function computeFallbackLocale($locale)
    {
        if (strrchr($locale, '_') !== false) {
            return substr($locale, 0, -strlen(strrchr($locale, '_')));
        }

        return false;
    }

    private function ensureIsIterableOrCollection($translations): void
    {
        if ($translations instanceof Collection) {
            return;
        }

        if (is_iterable($translations)) {
            return;
        }

        throw new InvalidArgumentException(
            sprintf(
            '$translations parameter must be iterable or %s',
            Collection::class
        )
        );
    }
}

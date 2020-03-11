<?php


namespace HabanaTech\BusinessModel\ORM\Traits;

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
     * @var array $translation
     *
     */
    protected array $translation = [];


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
    public function translate(?string $locale = null, bool $fallbackToDefault = true): array
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
     * Returns translation for specific locale.
     * If requested translation doesn't exist, it will try to fallback default locale
     *
     * @param string $locale The locale (en, ru, fr) | null If null, will try with current locale
     */
    protected function doTranslate(?string $locale = null, bool $fallbackToDefault = true): array
    {
        if ($locale === null) {
            $locale = $this->getCurrentLocale();
        } else {
            $this->locale = $locale;
        }


        foreach ($this->getTranslations() as $key => $translation) {

            if (isset($translation[$locale]) === true) {
                $this->translation[$key] = $translation[$locale];
            }
            elseif ($fallbackToDefault && isset($translation[$this->defaultLocale]))
            {
                $this->translation[$key] = $translation[$this->defaultLocale];
            }
            else $this->translation[$key] = null;

        }

        return $this->translation;
    }


}

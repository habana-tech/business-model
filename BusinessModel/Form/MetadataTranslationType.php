<?php


namespace App\Model\Form;

use App\Model\EventSubscriber\TranslationsSubscriber;
use App\Model\ORM\Interfaces\TranslatableInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Exception;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Model\AllowedLocales;

class MetadataTranslationType extends AbstractType implements DataMapperInterface
{
    /**
     * @var TranslationsSubscriber $translationsSubscriber
     */
    private TranslationsSubscriber $translationsSubscriber;

    /**
     * MetadataTranslationType constructor.
     * @param TranslationsSubscriber $translationsSubscriber
     */
    public function __construct(TranslationsSubscriber $translationsSubscriber)
    {
        $this->translationsSubscriber = $translationsSubscriber;
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        dump($options);
        exit();
        $builder->addEventSubscriber($this->translationsSubscriber);

        foreach (AllowedLocales::LOCALES as $LOCALE) {
            $builder->add($LOCALE, $options['current_field_type']);
        }

        $builder->setDataMapper($this);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'by_reference'       => false,
                'field'              => '',
                'current_field_type' => TextType::class,
            ]
        );

        $resolver->setNormalizer(
            'field',
            static function (Options $options, $value): string {
                if (empty($value) === true) {
                    throw new \RuntimeException(sprintf('Missing "field" option of "MetadataTranslationType".'));
                }

                return $value;
            }
        );
    }


    public function getBlockPrefix(): string
    {
        return 'metadata_translations';
    }

    /**
     * @inheritDoc
     * @var Form $parent
     */
    public function mapDataToForms($viewData, iterable $forms)
    {
        $forms  = iterator_to_array($forms);
        $entity = null;
        if (is_array($forms) === true) {

            $parent = $forms[array_key_first($forms)];
            while ($parent instanceof Form && ($parent->getViewData() instanceof TranslatableInterface) === false) {
                $parent = $parent->getParent();
            }
            $entity = $parent->getViewData();
        }

        if ($entity === null) {
            return;
        }

        $translations = $entity->getTranslations();

        foreach ($forms as $key => $value) {
            /**
             * @var Form $value
             */
            $field = $value->getParent() !== null ? $value->getParent()->getName() : null;
            if ($field !== null && isset($translations[$field][$key]) === true) {
                $value->setData($translations[$field][$key]);
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function mapFormsToData(iterable $forms, &$viewData)
    {
        // TODO: Implement mapFormsToData() method.
    }
}

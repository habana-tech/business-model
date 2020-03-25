<?php


namespace HabanaTech\BusinessModel\Form;

use HabanaTech\BusinessModel\EventSubscriber\TranslationsSubscriber;
use HabanaTech\BusinessModel\ORM\Interfaces\TranslatableInterface;
use RuntimeException;
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
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

class MetadataTranslationType extends AbstractType implements DataMapperInterface
{
    /**
     * @var TranslationsSubscriber $translationsSubscriber
     */
    private TranslationsSubscriber $translationsSubscriber;
    /**
     * @var ContainerBagInterface
     */
    private ContainerBagInterface $params;

    /**
     * MetadataTranslationType constructor.
     * @param TranslationsSubscriber $translationsSubscriber
     * @param ContainerBagInterface $params
     */
    public function __construct(
        TranslationsSubscriber $translationsSubscriber,
        ContainerBagInterface $params
    ) {
        $this->translationsSubscriber = $translationsSubscriber;
        $this->params = $params;
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventSubscriber($this->translationsSubscriber);

        // Default Locale.
        $locale = $this->params->get('default_locale') ?? 'en';

        $builder->add($locale, $options['current_field_type']);

        foreach (explode('|', $this->params->get('app_locales')) as $lang) {
            if ($locale !== $lang) {
                $builder->add($lang, $options['current_field_type']);
            }
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
                    throw new RuntimeException(sprintf('Missing "field" option of "MetadataTranslationType".'));
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

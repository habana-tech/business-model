<?php

namespace HabanaTech\BusinessModel\Form;

use HabanaTech\BusinessModel\ORM\Entity\FilterTag;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterTagType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('pinned')
//            ->add('language',  ChoiceType::class, ['choices' => [
//                'de' => 'de',
//                'en' => 'en',
//                'es' => 'es',
//                ]])
//            ->add('interests')
//            ->add('activities')
//            ->add('translation_from')
//            ->add('modified_by')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FilterTag::class,
        ]);
    }
}

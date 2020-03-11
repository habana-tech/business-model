<?php

namespace HabanaTech\BusinessModel\Form;

use HabanaTech\BusinessModel\ORM\Entity\DescriptionFragment;
use HabanaTech\BusinessModel\ORM\Entity\Image;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class DescriptionFragmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image', ImageUploadType::class, [
                'label' => null,
                'attr' => [
                    'required' => false,
                    'class' => 'image_upload_only_img_description'
                ]
            ])
            ->add('name', null, [
                'label' => 'Title for the Feature component',
                'attr' => [
                    'required' => true
                ]])

            ->add('imageField', SingleImageFromGalleryType::class, [
            ])
            ->add('content', CKEditorType::class)
            ->add('fragmentOrder', HiddenType::class, ['attr' => ['data-role' => 'fragmentOrder']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DescriptionFragment::class,
        ]);
    }
}

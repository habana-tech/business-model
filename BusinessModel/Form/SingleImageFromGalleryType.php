<?php

namespace HabanaTech\BusinessModel\Form;

use HabanaTech\BusinessModel\ORM\Models\SingleImageFromGallery;
use HabanaTech\BusinessModel\ORM\Interfaces\ImageFieldInterface;
use HabanaTech\BusinessModel\ORM\Entity\Image;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SingleImageFromGalleryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add(
                'imageFieldAction',
                ChoiceType::class,
                [
                    'choices' => [
                        'Use one image from gallery' => 'fromGallery',
                        'Update the current Image' => 'updateImage',
                        'Upload a new image, keep the current on gallery' => 'uploadNewImage'
                    ],

                    'expanded' => true,
                ]
            )
            ->add('galleryImage', EntityType::class, [
                'class' => Image::class,
                'placeholder' => 'Keep the current image',
                'help' => 'Choose an image from gallery to replace the current image',
                'multiple' => false,
                'required' => false,
                'choice_label' => 'description',
                'choice_value' => 'id',
                'attr' => [
                    'class' => 'selectpicker show-tick',
                    'data-live-search' => 'true',
                ],
                'choice_attr' => static function ($choice, $key, $value) {
                    return [
                        'data-content' => "<img style='width: 50px' 
                        class='lazyload'
                        src=" . $choice->getbase64() . "
                        data-src='/media/cache/resolve/min_width_40/static/uploads/images/" . $choice->getimageName() . "'> " . $choice->getDescription(),
                    ];
                },
            ])

            ->add('updateImage', ImageUploadType::class)

            ->add('uploadNewImage', ImageUploadType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SingleImageFromGallery::class,
            'block_name' => 'image_field',
            'block_prefix' => 'image_field'
        ]);
    }
}

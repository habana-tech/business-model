<?php

namespace HabanaTech\BusinessModel\Form;

use HabanaTech\BusinessModel\Form\ImageUploadType;
use HabanaTech\BusinessModel\ORM\Models\SingleImageFromGallery;
use HabanaTech\BusinessModel\ORM\Entity\Image;
use HabanaTech\BusinessModel\ORM\Repository\ImageRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class MultipleImageFromGalleryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('galleryImage', CollectionType::class, [
                'class' => Image::class,
                'placeholder' => 'Keep the current image',
                'help' => 'Choose an image from gallery to replace the current image',
                'multiple' => true,
                'required' => false,
                'choice_label' => 'description',
                'choice_value' => 'id',
                'attr' => [
                    'class' => 'selectpicker show-tick',
                    'data-live-search' => 'true',
                ],
                'query_builder' => static function (ImageRepository $er) {
                    return $er->createQueryBuilder('i')
                        ->orderBy('i.id', 'ASC');
                },
                'choices' => [0,1],
                'choice_attr' => static function ($choice, $key, $value) {
                    return [
                        /**
                         * @var Image $choice
                         */
                        'data-content' => "<img style='width: 50px' src=' /media/cache/resolve/min_width_40/static/uploads/images/" . $choice->getimageName() . "'> " . $choice->getDescription(),
                    ];
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Image::class,

        ]);
    }
}

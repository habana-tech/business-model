<?php

namespace HabanaTech\BusinessModel\Form;

use App\Form\Types\AppImageUploaderType;
use HabanaTech\BusinessModel\ORM\Entity\Image;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ImageUploadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('imageFile', AppImageUploaderType::class, [
                'label' => 'Upload an Image',
                'attr' => [
                    'required' => false,
                    'accept' => "image/*",
                    'style' => 'border solid 3px red;',
                    'onchange' => 'preview_image(event); alert(100);'
                ],
                'required' => false
            ])
            ->add('description', null, ['label' => 'Image description'])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
        ]);
    }
}

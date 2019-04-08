<?php

namespace App\Form;

use App\Entity\Picture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotNull;

class PictureFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('url', FileType::class, [
                'image_property' => 'imagePath',
                 //'multiple' => true,
                'mapped' => false,
                'attr' => [
                    'class' => 'pic',
                    'id' =>'pic',
                    //'onchange' => 'previewFile()'
                ],
                'constraints' => [
                    new Image(),
                    //new NotNull([
                      //  'message' => 'nvuçrevurebv'
                    //])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Picture::class
        ]);
    }

    public function getBlockPrefix()
    {
        return 'PictureFormType';
    }
}

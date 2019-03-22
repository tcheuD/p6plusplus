<?php

namespace App\Form;


use App\Entity\Category;
use App\Entity\Picture;
use App\Entity\Trick;
use App\Repository\PictureRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrickFormType extends AbstractType
{

    private $pictureRepository;

    public function __construct(PictureRepository $pictureRepository)
    {
        $this->pictureRepository = $pictureRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Nom de la figure'
            ])

            ->add('content', TextareaType::class, [
                'label' => 'Description'
            ])

            /**
            ->add('pictures', EntityType::class, [
                'class' => Picture::class,
                'label' => 'Photos',
                'multiple' => true,
                'choice_label' => function(Picture $picture) {
                    return sprintf($picture->getImagePath());
                },
               'choices' => $this->pictureRepository->findAll(),
            ])
             **/

            ->add('mainPicture', PictureFormType::class, [
                'label' => 'Image principale'
            ])

            ->add('pictures', CollectionType::class, [
                'entry_type' => PictureFormType::class,
                'entry_options' => ['label' => true],
                'prototype' => true,
                'required' => true,
                'allow_add'     => true,
                'allow_delete'  => true,
                'by_reference'  => true,
                'label' => 'Images',
                //'mapped' => false,
                'attr'          => [
                    'class' => 'collection-pictures',
                ],
            ])


            ->add('category', EntityType::class, [
                'class' => Category::class,
                'label' => 'Categorie'
            ])

            ->add('videos', CollectionType::class, [
                'entry_type' => VideoFormType::class,
                'entry_options' => ['label' => true],
                'prototype' => true,
                'required' => true,
                'allow_add'     => true,
                'allow_delete'  => true,
                'by_reference'  => true,
                'label' => 'Videos',
                'attr'          => [
                    'class' => 'collection-videos',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Trick::class
        ]);
    }


}

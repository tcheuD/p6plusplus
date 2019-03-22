<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Picture;
use App\Entity\Trick;
use App\Repository\PictureRepository;
use App\Repository\TrickRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditTrickFormType extends AbstractType
{

    private $pictureRepository;
    private $trickRepository;

    public function __construct(PictureRepository $pictureRepository, TrickRepository $trickRepository)
    {
        $this->pictureRepository = $pictureRepository;
        $this->trickRepository = $trickRepository;
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

            ->add('category', EntityType::class, [
                'class' => Category::class,
                'label' => 'Categorie'
            ])

            ->add('mainPicture', ChoiceType::class, [
                'label' => 'Image principale',
                'choice_label' => function(Picture $picture) {
                    return sprintf($picture->getUrl());
                },
                'choices' => $options['data']->getPictures(),
                'attr' => ['class' => 'save'],
            ])


            ->add('pictures', CollectionType::class, [
                'entry_type' => PictureFormType::class,
                'entry_options' => ['label' => true],
                'prototype' => true,
                'required' => false,
                'allow_add'     => true,
                'allow_delete'  => true,
                'by_reference'  => true,
                'label' => 'Images',
                //'mapped' => false,
                'attr'          => [
                    'class' => 'collection-pictures',
                ],
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
                //'mapped' => false,
                'attr'          => [
                    'class' => 'collection-videos',
                ],
            ])

            ->addEventListener(
                FormEvents::PRE_SET_DATA,
                function (FormEvent $event) {
                    /** @var Trick|null $data */
                    $data = $event->getData();
                    if (!$data) {
                        return;
                    }
                    $this->setupSpecificLocationNameField(
                        $event->getForm(),
                        $data->getPictures()
                    );
                }
            )

            ->get('pictures')->addEventListener(
                FormEvents::POST_SUBMIT,
                function(FormEvent $event) {
                    $form = $event->getForm();
                    $this->setupSpecificLocationNameField(
                        $form->getParent(),
                        $form->getData()
                    );
                }
            );
    }

    private function setupSpecificLocationNameField(FormInterface $form, $picture)
    {

        if (null === $picture) {
            $form->remove('specificLocationName');
            return;
        }
        $picture = $picture->toArray();
        $form->add('mainPicture', ChoiceType::class, [
        'label' => 'Image principale',
        'choice_label' => function(Picture $picturee) {
            return sprintf($picturee->getUrl());
        },
        'choices' => $picture,
        'attr' => ['class' => 'save'],
    ]);
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Trick::class
        ]);
    }

}

<?php

namespace App\Form;


use App\Entity\Category;
use App\Entity\Picture;
use App\Entity\Trick;
use App\Repository\PictureRepository;
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
            ->add('title', TrickTitleType::class, [
                'data_class' => Trick::class,
            ])

            ->add('content', TextareaType::class, [
                'label' => 'Description'
            ])

            ->add('mainPicture', ChoiceType::class, [
                'label' => 'Image principale',
                'choices' => null,
                'attr' => ['class' => 'save'],
            ])

            ->add('category', EntityType::class, [
                'class' => Category::class,
                'label' => 'Categorie'
            ])

            ->add('videos', CollectionType::class, [
                'entry_type' => VideoFormType::class,
                'entry_options' => ['label' => true],
                'prototype' => true,
                'required' => false,
                'allow_add'     => true,
                'allow_delete'  => true,
                'by_reference'  => true,
                'label' => 'Videos',
                'attr'          => [
                    'class' => 'collection-videos',
                ],
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
                'attr'          => [
                    'class' => 'collection-pictures',
                ],
            ])

            ->addEventListener(
                FormEvents::PRE_SUBMIT,
                function (FormEvent $event) {
                    /** @var Trick|null $data **/
                    $data = $event->getData();
                    if (!isset($data['pictures'])) {
                        return;
                    }
                    $this->setupSpecificLocationNameField(
                        $event->getForm(),
                        $data['pictures']
                    );
                }
            )
              ->get('mainPicture')->addEventListener(
                FormEvents::PRE_SUBMIT, //presubmit
                function(FormEvent $event) {
                    $form = $event->getForm();
                    $this->setupSpecificLocationNameField(
                        $form->getParent(),
                        $event->getData()
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


        $picture = array_keys($picture);

        $form->add('mainPicture', ChoiceType::class, [
            'label' => 'Image principale',
            'choices' => $picture,
            'attr' => ['class' => 'save image-picker'],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Trick::class
        ]);
    }


}

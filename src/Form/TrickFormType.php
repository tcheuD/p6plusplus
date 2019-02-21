<?php

namespace App\Form;


use App\Entity\Category;
use App\Entity\Picture;
use App\Entity\Trick;
use App\Repository\PictureRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
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
            ->add('title', TextType::class)
            ->add('content')
            ->add('videos')
            ->add('pictures', EntityType::class, [
                'class' => Picture::class,
                'multiple' => true,
                'choice_label' => function(Picture $picture) {
                    return sprintf($picture->getImagePath());
                },
               'choices' => $this->pictureRepository->findUnusedPicByUser(),
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Trick::class
        ]);
    }


}

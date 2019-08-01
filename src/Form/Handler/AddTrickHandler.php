<?php

namespace App\Form\Handler;

use App\Factory\PictureFactory;
use App\Factory\VideoFactory;
use App\Service\FileUploader;
use App\Service\SlugBuilder;
use Symfony\Component\Form\FormInterface;

class AddTrickHandler
{

    public function handle(FormInterface $form,  $user, FileUploader $fileUploader)
    {

        if ($form->isSubmitted() && $form->isValid()) {

            $slugBuilder = new SlugBuilder();
            $trick = $form->getData();

            $trick->setSlug($slugBuilder->buildSlug($trick->getTitle()));
            $trick->setCreatedBy($user);

            $videosCollection = $form->getData()->getVideos()->toArray();
            VideoFactory::set($videosCollection, $trick);

            $picturesCollection = $form->getData()->getPictures()->toArray();
            PictureFactory::add($picturesCollection, $form, $trick, $fileUploader);

            return $trick;
        }

        return false;
    }

}

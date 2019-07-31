<?php

namespace App\Form\Handler;

use App\Entity\Trick;
use App\Factory\PictureFactory;
use App\Factory\VideoFactory;
use App\Service\FileUploader;
use App\Service\SlugBuilder;
use Symfony\Component\Form\FormInterface;

class EditTrickHandler
{

    public function handle(FormInterface $form,  Trick $trick, $user, FileUploader $fileUploader)
    {
        if ($form->isSubmitted() && $form->isValid()) {

            $slugBuilder = new SlugBuilder();
            $mainPicture = $form['mainPicture']->getData();
            $trick = $form->getData();

            $trick->setSlug($slugBuilder->buildSlug($trick->getTitle()));
            $trick->setUpdatedBy($user);
            $trick->setMainPicture($mainPicture);
            $trick->setModificationDate(new \DateTime());


            $videosCollection = $form->getData()->getVideos()->toArray();
            VideoFactory::set($videosCollection, $trick);

            $picturesCollection = $form->getData()->getPictures()->toArray();
            PictureFactory::edit($picturesCollection, $form, $trick, $fileUploader);


            return true;
        }

        return false;
    }

}

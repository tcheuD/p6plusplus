<?php

namespace App\Form\Handler;

use App\Entity\Trick;
use Symfony\Component\Form\FormInterface;

class AddTrickHandler
{
    public function handle(FormInterface $form, Trick $trick, $user)
    {
        if ($form->isSubmitted() && $form->isValid()) {

            $trick = $form->getData();

            $trick->setSlug(strtolower(str_replace(' ', '-', $trick->getTitle())));
            $trick->setCreatedBy($user);


            $videosCollection = $form->getData()->getVideos()->toArray();
            foreach ($videosCollection as $b => $video) {
                preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $video->getUrl(), $match);
                $videos[] = $video->getUrl();
                $video->setNumber(1);
                $video->setTrick($trick);
                $video->setCreationDate(new \DateTime());
                $video->setIdentif($match[1]);
                $video->setAuthor($trick->getCreatedBy());
            }

            $picturesCollection = $form->getData()->getPictures()->toArray();
            foreach ($picturesCollection as $b => $picture) {
                $videos[] = $picture->getUrl();
                $picture->setAuthor($trick->getCreatedBy());
                $picture->setTrick($trick);
            }

            return true;
        }

        return false;
    }

}

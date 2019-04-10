<?php

namespace App\Form\Handler;

use App\Entity\Picture;
use App\Entity\Trick;
use App\Entity\Video;
use App\Service\FileUploader;
use App\Service\SlugBuilder;
use App\Service\VideoIdExtractor;
use Symfony\Component\Form\FormInterface;

class AddTrickHandler
{

    public function handle(FormInterface $form,  Trick $trick, $user, FileUploader $fileUploader)
    {
        if ($form->isSubmitted() && $form->isValid()) {

            $videoIdExtractor = new VideoIdExtractor();
            $slugBuilder = new SlugBuilder();

            $trick = $form->getData();

            $trick->setSlug($slugBuilder->buildSlug($trick->getTitle()));
            $trick->setCreatedBy($user);
            $trick->setMainPicture('images/'.$fileUploader->upload($form['mainPicture']['url']->getData()));


            $videosCollection = $form->getData()->getVideos()->toArray();
            foreach ($videosCollection as $b => $video) {

                /** @var Video $video */
                $videos[] = $video->getUrl();
                $video->setNumber(1);
                $video->addTrick($trick);
                $video->setCreationDate(new \DateTime());
                $video->setIdentif($videoIdExtractor->urlToId($video->getUrl()));
                $video->setAuthor($trick->getCreatedBy());
            }

            $picturesCollection = $form->getData()->getPictures()->toArray();
            foreach ($picturesCollection as $b => $picture) {

                $filename = $fileUploader->upload($form['pictures'][$b]['url']->getData());

                /** @var Picture $picture */
                $pictures[] = $picture->getUrl();
                $picture->setAuthor($trick->getCreatedBy());
                $picture->addTrick($trick);
                $picture->setUrl($filename);
                $picture->setNumber(1);
                $picture->setCreationDate(new \DateTime());
            }

            return true;
        }

        return false;
    }

}

<?php

namespace App\Form\Handler;

use App\Entity\Trick;
use App\Service\SlugBuilder;
use App\Service\VideoIdExtractor;
use Symfony\Component\Form\FormInterface;

class AddTrickHandler
{

    public function handle(FormInterface $form, Trick $trick, $user)
    {
        if ($form->isSubmitted() && $form->isValid()) {

            $videoIdExtractor = new VideoIdExtractor();
            $slugBuilder = new SlugBuilder();

            $trick = $form->getData();

            $trick->setSlug($slugBuilder->buildSlug($trick->getTitle()));
            $trick->setCreatedBy($user);


            $videosCollection = $form->getData()->getVideos()->toArray();
            foreach ($videosCollection as $b => $video) {

                $videos[] = $video->getUrl();
                $video->setNumber(1);
                $video->setTrick($trick);
                $video->setCreationDate(new \DateTime());
                $video->setIdentif($videoIdExtractor->urlToId($video->getUrl()));
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

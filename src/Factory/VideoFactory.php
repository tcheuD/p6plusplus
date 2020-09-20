<?php

namespace App\Factory;

use App\Entity\Trick;
use App\Entity\Video;
use App\Service\VideoIdExtractor;

class VideoFactory
{
    public static function set($videosCollection, Trick $trick) {
        $videoIdExtractor = new VideoIdExtractor();

        foreach ($videosCollection as $b => $video) {

            /** @var Video $video */
            $videos[] = $video->getUrl();
            $video->setNumber(1);
            $video->addTrick($trick);
            $video->setCreationDate(new \DateTime());
            $video->setIdentif($videoIdExtractor->urlToId($video->getUrl()));
            $video->setAuthor($trick->getCreatedBy());
        }
    }

}

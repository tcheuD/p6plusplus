<?php

namespace App\Factory;


use App\Entity\Picture;
use App\Entity\Trick;
use App\Service\FileUploader;

class PictureFactory
{
    public static function add($picturesCollection, $form, Trick $trick, FileUploader $fileUploader)
    {
        foreach ($picturesCollection as $b => $picture) {

            $filename = $fileUploader->upload($form['pictures'][$b]['url']->getData());

            /** @var Picture $picture */
            $pictures[] = $picture->getUrl();
            $picture->setAuthor($trick->getCreatedBy());
            $picture->addTrick($trick);
            $picture->setUrl($filename);
            $picture->setNumber($b);
            $picture->setCreationDate(new \DateTime());

            if ($b === intval($trick->getMainPicture())) {
                $trick->setMainPicture('images/' . $filename);
            }
        }
    }

    public static function edit($picturesCollection, $form, Trick $trick, FileUploader $fileUploader) {
        foreach ($picturesCollection as $b => $picture) {

            if(!is_null($form['pictures'][$b]['url']->getData()))
            {
                $filename = $fileUploader->upload($form['pictures'][$b]['url']->getData());

                /** @var Picture $picture */
                $pictures[] = $picture->getUrl();
                $picture->setAuthor($trick->getCreatedBy());
                $picture->addTrick($trick);
                $picture->setUrl($filename);
                $picture->setNumber(1);
                $picture->setCreationDate(new \DateTime());
            }
        }
    }
}

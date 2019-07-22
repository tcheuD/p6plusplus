<?php

namespace App\EventListener;


use App\Entity\Picture;
use App\Entity\Trick;
use App\Service\FileUploader;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

//TODO: current status: handle only uploads from Picture entity, need to handle Tick's main pic as wel
class PictureUploadListener
{
    private $uploader;

    public function __construct(FileUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

    private function uploadFile($entity)
    {
        $file = $entity->getUrl();

        if ($file instanceof UploadedFile) {
            $fileName = $this->uploader->upload($file);
            $entity->setUrl($fileName);
        } elseif ($file instanceof File) {
            $entity->setUrl($file->getFilename());
        }
    }

    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Picture) {
            return;
        }

        if ($fileName = $entity->getUrl()) {
            $entity->setUrl(new File($this->uploader->getTargetDirectory().'/'.$fileName));
        }
    }
}

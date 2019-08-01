<?php

namespace App\Form\Handler;

use App\Entity\User;
use App\Service\FileUploader;
use Symfony\Component\Form\FormInterface;

class UserRegistrationHandler
{

    public function handle(FormInterface $form, $user, $passwordEncoder, FileUploader $fileUploader)
    {
        if ($form->isSubmitted() && $form->isValid()) {

            /** @var User $user */
            $user = $form->getData();

            $user->setRegistrationDate(new \DateTime());
            if ($form['ProfilePicture']->getData()) {
                $user->setPicture($fileUploader->upload($form['ProfilePicture']->getData()));
            }
            else
            {
                $user->setPicture('default_pp_snowtricks.png');
            }
            $user->setPassword($passwordEncoder->encodePassword(
                $user,
                $form['plainPassword']['plainPassword']->getData()
            ));

            return true;
        }

        return false;
    }
}

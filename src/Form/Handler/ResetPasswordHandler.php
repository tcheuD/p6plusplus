<?php

namespace App\Form\Handler;

use App\Entity\User;
use App\Service\FileUploader;
use Symfony\Component\Form\FormInterface;

class ResetPasswordHandler
{

    public function handle(FormInterface $form, $passwordEncoder, $user)
    {
            /** @var User $user */
            $user->setPassword($passwordEncoder->encodePassword(
                $user,
                $form['plainPassword']->getData()
            ));

            return $user;
    }
}

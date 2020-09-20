<?php

namespace App\Form\Handler;


use App\Entity\User;
use Symfony\Component\Form\FormInterface;

class ForgotPasswordHandler
{
    public function handle(FormInterface $form)
    {
        /** @var User $user */
        $user = $form->getData();
    }

}

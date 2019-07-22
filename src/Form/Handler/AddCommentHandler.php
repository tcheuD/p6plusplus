<?php

namespace App\Form\Handler;

use App\Entity\Comment;
use App\Entity\Trick;
use App\Entity\User;
use Symfony\Component\Form\FormInterface;

class AddCommentHandler
{

    public function handle(FormInterface $form, Trick $trick, User $user)
    {
            /** @var Comment $comment */
            $comment = $form->getData();
            $comment->setCommentDate(new \DateTime());
            $comment->setUser($user);
            $comment->setTrick($trick);

            return $comment;
    }

}

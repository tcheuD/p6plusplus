<?php

namespace App\Tests\Entity;

use App\Entity\Comment;
use App\Entity\User;
use DateTime;
use PHPUnit\Framework\TestCase;

class CommentTest extends TestCase
{
    public function testGetComment(): void
    {
        $comment = new Comment();
        $comment->setComment('comment');

        self::assertSame('comment', $comment->getComment());
    }

    public function testGetUser(): void
    {
        $comment = new Comment();
        $user = new User();

        $comment->setUser($user);

        self::assertSame($user, $comment->getUser());
    }

    public function testGetCommentDate(): void
    {
        $comment = new Comment();
        $date = new DateTime();

        $comment->setCommentDate($date);

        self::assertSame($date, $comment->getCommentDate());
    }
}

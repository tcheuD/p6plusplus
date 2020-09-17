<?php

namespace App\Tests\Entity;

use App\Entity\Trick;
use App\Entity\User;
use App\Entity\Video;
use DateTime;
use PHPUnit\Framework\TestCase;

class VideoTest extends TestCase
{
    public function testGetNumber(): void
    {
        $video = new Video();

        $video->setNumber(10);

        self::assertSame(10, $video->getNumber());
    }

    public function testGetUrl(): void
    {
        $video = new Video();

        $video->setUrl('video.com');

        self::assertSame('video.com', $video->getUrl());
    }

    public function testGetPlatform(): void
    {
        $video = new Video();

        $video->setPlatform('platform');

        self::assertSame('platform', $video->getPlatform());
    }

    public function testGetCreationDate(): void
    {
        $video = new Video();
        $dateTime = new DateTime();

        $video->setCreationDate($dateTime);

        self::assertSame($dateTime, $video->getCreationDate());
    }

    public function testGetAuthor(): void
    {
        $video = new Video();
        $author = new User();

        $video->setAuthor($author);

        self::assertSame($author, $video->getAuthor());
    }

    public function testGetIdentif(): void
    {
        $video = new Video();

        $video->setIdentif('identif');

        self::assertSame('identif', sprintf($video));
    }

    public function testItRemoveTricks(): void
    {
        $video = new Video();
        $trick1 = new Trick();
        $trick2 = new Trick();
        $trick3 = new Trick();

        $video->addTrick($trick1);
        $video->addTrick($trick2);
        $video->addTrick($trick3);
        $video->removeTrick($trick1);

        self::assertCount(2, $video->getTricks());
    }
}

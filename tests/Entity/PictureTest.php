<?php

namespace App\Tests\Entity;

use App\Entity\Picture;
use App\Entity\Trick;
use App\Entity\User;
use DateTime;
use PHPUnit\Framework\TestCase;

class PictureTest extends TestCase
{
    public function testGetNumber(): void
    {
        $picture = new Picture();

        $picture->setNumber(10);

        self::assertSame(10, $picture->getNumber());
    }

    public function testGetUrl(): void
    {
        $picture = new Picture();

        $picture->setUrl('fake/path.jpg');

        self::assertSame('fake/path.jpg', $picture->getUrl());
    }

    public function testGetImagePath(): void
    {
        $picture = new Picture();

        $picture->setUrl('fake/path.jpg');

        self::assertSame('images/fake/path.jpg', sprintf($picture));
    }

    public function testGetCreationDate(): void
    {
        $picture = new Picture();
        $dateTime = new DateTime();

        $picture->setCreationDate($dateTime);

        self::assertSame($dateTime, $picture->getCreationDate());
    }

    public function testGetAuthor(): void
    {
        $picture = new Picture();
        $author = new User();

        $picture->setAuthor($author);

        self::assertSame($author, $picture->getAuthor());
    }

    public function testGetFilename(): void
    {
        $picture = new Picture();

        $picture->setFilename('filename');

        self::assertSame('filename', $picture->getFilename());
    }

    public function testItRemoveTricks(): void
    {
        $picture = new Picture();
        $trick1 = new Trick();
        $trick2 = new Trick();
        $trick3 = new Trick();

        $picture->addTrick($trick1);
        $picture->addTrick($trick2);
        $picture->addTrick($trick3);
        $picture->removeTrick($trick1);

        self::assertCount(2, $picture->getTricks());
    }
}

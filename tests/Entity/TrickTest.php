<?php

namespace App\Tests\Entity;

use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Picture;
use App\Entity\Trick;
use App\Entity\User;
use App\Entity\Video;
use DateTime;
use PHPUnit\Framework\TestCase;

class TrickTest extends TestCase
{
    public function testGetTitle(): void
    {
        $trick = new Trick();

        $trick->setTitle('Title');

        self::assertSame('Title', $trick->getTitle());

    }

    public function testGetContent(): void
    {
        $trick = new Trick();

        $trick->setContent('Content');

        self::assertSame('Content', $trick->getContent());

    }

    public function testGetSlug(): void
    {
        $trick = new Trick();

        $trick->setSlug('slug-trick');

        self::assertSame('slug-trick', $trick->getSlug());
    }

    public function testGetCreationDate(): void
    {
        $trick = new Trick();
        $dateTime = new DateTime();
        $trick->setCreationDate($dateTime);
        self::assertSame($dateTime, $trick->getCreationDate());
    }

    public function testGetModificationDate(): void
    {
        $trick = new Trick();
        $dateTime = new DateTime();

        $trick->setModificationDate($dateTime);

        self::assertSame($dateTime, $trick->getModificationDate());
    }

    public function testGetCreatedBy(): void
    {
        $trick = new Trick();
        $author = new User();

        $trick->setCreatedBy($author);

        self::assertSame($author, $trick->getCreatedBy());
    }

    public function testGetUpdatedBy(): void
    {
        $trick = new Trick();
        $author = new User();

        $trick->setUpdatedBy($author);

        self::assertSame($author, $trick->getUpdatedBy());
    }

    public function testGetCategory(): void
    {
        $trick = new Trick();
        $category = new Category();

        $trick->setCategory($category);

        self::assertSame($category, $trick->getCategory());
    }

    public function testGetMainPicturePath(): void
    {
        $trick = new Trick();

        $trick->setMainPicture('mainPicture');

        self::assertSame('mainPicture', $trick->getMainPicturePath());
    }

    public function testItRemoveComment(): void
    {
        $trick = new Trick();
        $comment1 = new Comment();
        $comment2 = new Comment();
        $comment3 = new Comment();

        $trick->addComment($comment1);
        $trick->addComment($comment2);
        $trick->addComment($comment3);
        $trick->removeComment($comment2);

        self::assertCount(2, $trick->getComments());
    }

    public function testItRemovePicture(): void
    {
        $trick = new Trick();
        $picture1 = new Picture();
        $picture2 = new Picture();
        $picture3 = new Picture();

        $trick->addPicture($picture1);
        $trick->addPicture($picture2);
        $trick->addPicture($picture3);
        $trick->removePicture($picture1);

        self::assertCount(2, $trick->getPictures());
    }

    public function testItRemoveVideo(): void
    {
        $trick = new Trick();
        $video1 = new Video();
        $video2 = new Video();
        $video3 = new Video();

        $trick->addVideo($video1);
        $trick->addVideo($video2);
        $trick->addVideo($video3);
        $trick->removeVideo($video1);

        self::assertCount(2, $trick->getVideos());
    }
}

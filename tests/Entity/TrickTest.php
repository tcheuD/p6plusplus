<?php

namespace App\Tests\Entity;

use App\Entity\Trick;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class TrickTest extends TestCase
{
    public function testGetTitle()
    {
        $trick = new Trick();
        $trick->setTitle('Title');
        $this->assertSame('Title', $trick->getTitle());

    }

    public function testGetContent()
    {
        $trick = new Trick();
        $trick->setContent('Content');
        $this->assertSame('Content', $trick->getContent());

    }

    public function testGetSlug()
    {
        $trick = new Trick();
        $trick->setSlug('slug-trick');
        $this->assertSame('slug-trick', $trick->getSlug());
    }

    public function testGetCreationDate()
    {
        $trick = new Trick();
        $dateTime = new \DateTime();
        $trick->setCreationDate($dateTime);
        $this->assertSame($dateTime, $trick->getCreationDate());
    }

    public function testGetModificationDate()
    {
        $trick = new Trick();
        $dateTime = new \DateTime();
        $trick->setModificationDate($dateTime);
        $this->assertSame($dateTime, $trick->getModificationDate());
    }

    public function testGetCreatedBy()
    {
        $trick = new Trick();
        $author = new User();
        $trick->setCreatedBy($author);
        $this->assertSame($author, $trick->getCreatedBy());
    }

    public function testGetUpdatedBy()
    {
        $trick = new Trick();
        $author = new User();
        $trick->setUpdatedBy($author);
        $this->assertSame($author, $trick->getUpdatedBy());
    }
}

<?php

namespace App\Tests\Entity;

use App\Entity\Category;
use App\Entity\Trick;
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{
    public function testGetName(): void
    {
        $category = new Category();
        $category->setName('test');

        self::assertSame('test', sprintf($category));
    }

    public function testItRemoveVideo(): void
    {
        $category = new Category();
        $trick1 = new Trick();
        $trick2 = new Trick();
        $trick3 = new Trick();

        $category->addTrick($trick1);
        $category->addTrick($trick2);
        $category->addTrick($trick3);
        $category->removeTrick($trick1);

        self::assertCount(2, $category->getTrick());
    }
}

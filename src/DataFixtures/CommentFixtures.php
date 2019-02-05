<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CommentFixtures extends BaseFixture implements DependentFixtureInterface
{
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(50, 'comments', function ($i) {
            $comment = new Comment();
            $comment->setComment($this->faker->paragraph(1))
               ->setCommentDate($this->faker->dateTimeBetween('-100 days', '-1 days'))
               ->setTrick($this->getRandomReference('trick'))
               ->setUser($this->getRandomReference('user'));

            return $comment;
        });

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            TrickFixtures::class,
            UserFixture::class,
        ];
    }


}

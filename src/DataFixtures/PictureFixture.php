<?php

namespace App\DataFixtures;

use App\Entity\Picture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class PictureFixture extends BaseFixture implements DependentFixtureInterface
{
    private static $url = [
        '1.jpg',
        '2.jpg',
        '3.jpg',
        '4.jpg',
        '5.jpg',
        '6.jpg',
        '7.jpg',
        '8.jpg',
        '9.jpg',
        '10.jpg',
        '11.jpg',
    ];

    public function loadData(ObjectManager $manager)
    {
        $this->createMany(30, 'picture', function ($i) {
            $picture = new Picture();
            $picture->setUrl($this->faker->randomElement(self::$url));
            $picture->setNumber(1);
            $picture->setAuthor($this->getRandomReference('user'));
            $picture->setCreationDate($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $picture->setTrick($this->getRandomReference('trick'));

            return $picture;
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

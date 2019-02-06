<?php

namespace App\DataFixtures;

use App\Entity\Video;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class VideoFixture extends BaseFixture implements DependentFixtureInterface
{
    private static $url = [
        'https://youtu.be/TFVWhh0Gars',
        'https://youtu.be/xyPeVKGv58w',
        'https://youtu.be/XyARvRQhGgk',
        'https://youtu.be/-p_Nu4AHM6Q',
        'https://youtu.be/cYGI1Q7O_a0',
        'https://youtu.be/UU9iKINvlyU',
        'https://youtu.be/6zALCB6WJBI',
        'https://youtu.be/TTgeY_XCvkQ',
        'https://youtu.be/SQyTWk7OxSI',
        'https://youtu.be/rB9lOfv0oPQ',
        'https://youtu.be/74UEgGrawKA',
    ];

    public function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'video', function ($i) {
            $video = new Video();
            $video->setTrick($this->getRandomReference('trick'));
            $video->setCreationDate($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $video->setAuthor($this->getRandomReference('user'));
            $video->setNumber(1);
            $video->setUrl($this->faker->randomElement(self::$url));
            $video->setPlatform('youtube');

            return $video;
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

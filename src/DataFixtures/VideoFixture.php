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
        'https://youtu.be/K-apShaeSgY',
        'https://youtu.be/Xs-JfPjgiA4',
        'https://youtu.be/de50trNEvf8',
        'https://youtu.be/WNW90gFK9Cs',
        'https://youtu.be/0AbiygSo478',
        'https://www.youtube.com/watch?v=n0F6hSpxaFc',
        'https://youtu.be/UGdif-dwu-8',
        'https://youtu.be/FNyCrnsMlDE',
        'https://youtu.be/AI1m8NF7sp4',
        'https://youtu.be/1z4LMq8d7DI',
        'https://youtu.be/LRfk90XHqyY',
        'https://youtu.be/SDP6eGGYqYA',
        'https://youtu.be/RY8CBQZEZ34',
        'https://youtu.be/Vdz2TPtCmAk',
        'https://youtu.be/3_fr5l-JvTM',
        'https://youtu.be/JYz3tc5NuGY',
        'https://youtu.be/OvZdr4XM_UE',
        'https://youtu.be/SDdfIqJLrq4',
        'https://youtu.be/eEQ9Tq0RRIg',
        'https://youtu.be/JxOaXPwwWwo',
    ];

    public function loadData(ObjectManager $manager)
    {
        $this->createMany(30, 'video', function ($i) {
            $videoUrl = self::$url[$i];

            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $videoUrl, $match);


            $video = new Video();
            $video->setTrick($this->getRandomReference('trick'));
            $video->setCreationDate($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $video->setAuthor($this->getRandomReference('user'));
            $video->setNumber(1);
            $video->setUrl($videoUrl);
            $video->setIdentif($match[1]);
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

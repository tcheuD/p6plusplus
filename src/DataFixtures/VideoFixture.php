<?php

namespace App\DataFixtures;

use App\Entity\Video;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class VideoFixture extends BaseFixture implements DependentFixtureInterface
{
    private static $urls = [
        'Big Air' => [
            'https://www.youtube.com/watch?v=KdZ7mOMHdD0',
            'https://www.youtube.com/watch?v=zfRShgrtig4',
            'https://www.youtube.com/watch?v=RUErt8l7zOY',
            'https://www.youtube.com/watch?v=VEQ-s679a10',
            ],
        'Ollie' => [
            '1https://www.youtube.com/watch?v=kOyCsY4rBH0',
            'https://www.youtube.com/watch?v=SXFQCgw-V_k',
            ],
        'Nollie' => [
            'https://www.youtube.com/watch?v=Ki1WSzpJyz0',
            'https://www.youtube.com/watch?v=xyPeVKGv58w',
            'https://www.youtube.com/watch?v=H_tSuAipjWc',
            ],
        'Switch ollie' => [
            'https://www.youtube.com/watch?v=yRCUEfLEvZs',
            ],
        'One-Two' => [
            'https://www.youtube.com/watch?v=HFjXm2Mn3eQ',
            ],
        'A B' => [
            'https://www.youtube.com/watch?v=_utmUjLD7DE',
            ],
        'Bloody Dracula' => [
            'https://www.youtube.com/watch?v=UU9iKINvlyU',
            'https://www.youtube.com/watch?v=v7AmF8c4ZLw',
            'https://www.youtube.com/watch?v=0J8QMsL9DC4',
            'https://www.youtube.com/watch?v=t_bqZDLLL_c',
            ],
        'Canadian Bacon' => [
            'https://www.youtube.com/watch?v=6zALCB6WJBI',
            'https://www.youtube.com/watch?v=IVUSdEBRZ0Q',
            ],
        'Chicken Salad' => [
            'https://www.youtube.com/watch?v=TTgeY_XCvkQ',
            'https://www.youtube.com/watch?v=9rIWDl8QcUY',
            ],
        'China air' => [
            'https://www.youtube.com/watch?v=cvt0mRTzfx0',
            ],
        'Crail' => [
            'https://www.youtube.com/watch?v=eTx2uVcbLzM',
            'https://www.youtube.com/watch?v=cbfWyGOvkJk',
            'https://www.youtube.com/watch?v=rB9lOfv0oPQ',
            ],
        'Cross-rocket' => [
            'https://www.youtube.com/watch?v=74UEgGrawKA',
            'https://www.youtube.com/watch?v=iFUOt4QYpZs',
            ],
    ];

    public function loadData(ObjectManager $manager)
    {
        $i= -1;
        foreach (self::$urls as $key => $value) {
            $i++;
            foreach ($value as $url) {
                preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);

                $video = new Video();
                $video->addTrick($this->getReference('trick_'.$i));
                $video->setCreationDate($this->faker->dateTimeBetween('-100 days', '-1 days'));
                $video->setAuthor($this->getRandomReference('user'));
                $video->setNumber(1);
                $video->setUrl($url);
                $video->setIdentif($match[1]);
                $video->setPlatform('youtube');

                $manager->persist($video);
            }
        }

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

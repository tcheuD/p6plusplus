<?php

namespace App\DataFixtures;

use App\Entity\Trick;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class TrickFixtures extends BaseFixture implements DependentFixtureInterface
{
    private static $titles = [
        'Ollie',
        'Nollie',
        'Switch ollie',
        'One-Two',
        'A B',
        'Bloody Dracula',
        'Canadian Bacon',
        'Chicken Salad',
        'China air',
        'Crail',
        'Cross-rocket',
    ];

    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'trick', function ($i) {
            $trick = new Trick();
            $title = self::$titles[$i];
            $trick->setTitle($title)
                ->setCreationDate($this->faker->dateTimeBetween('-100 days', '-1 days'))
                ->setCategory($this->getRandomReference('category'))
                ->setCreatedBy($this->getRandomReference('user'))
                ->setContent($this->faker->realText())
                ->setSlug(strtolower(str_replace(' ', '-', $title)))
                ->setMainPicture('1.jpg');

            return $trick;
        });
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixture::class,
            CategoryFixtures::class,
        ];
    }
}

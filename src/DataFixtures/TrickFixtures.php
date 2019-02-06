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
            $trick->setTitle($this->faker->randomElement(self::$titles))
                ->setCreationDate($this->faker->dateTimeBetween('-100 days', '-1 days'))
                ->setCategory('snow')
                ->setCreatedBy($this->getRandomReference('user'))
                ->setContent($this->faker->realText());

            return $trick;
        });
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixture::class,
        ];
    }
}

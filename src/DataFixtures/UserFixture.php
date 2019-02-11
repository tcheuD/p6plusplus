<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixture extends BaseFixture
{
    private static $picture = [
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
        $this->createMany(10, 'user', function ($i) {
           $user = new User();
           $user->setEmail(sprintf('snowtrick@snowtrick.com', $i));
           $user->setFirstname($this->faker->firstName());
           $user->setName($this->faker->name());
           $user->setPassword($this->faker->password());
           $user->setForgotPassIdentity($this->faker->password());
           $user->setRegistrationDate($this->faker->dateTimeBetween('-100 days', '-1 days'));
           $user->setPicture($this->faker->randomElement(self::$picture));

           return $user;
        });

        $manager->flush();
    }
}

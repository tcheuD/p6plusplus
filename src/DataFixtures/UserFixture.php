<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixture extends BaseFixture
{
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'user', function ($i) {
           $user = new User();
           $user->setEmail(sprintf('snowtrick@snowtrick.com', $i));
           $user->setUsername($this->faker->name());
           $user->setPassword($this->faker->password());
           $user->setForgotPassIdentity($this->faker->password());
           $user->setRegistrationDate($this->faker->dateTimeBetween('-100 days', '-1 days'));

           return $user;
        });

        $manager->flush();
    }
}

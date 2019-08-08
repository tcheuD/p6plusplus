<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends BaseFixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'user', function ($i) {
           $user = new User();
           $user->setEmail(sprintf('snowtrick%d@snowtrick.com', $i));
           $user->setFirstname($this->faker->firstName());
           $user->setPassword($this->passwordEncoder->encodePassword(
               $user,
               'password' // Safest password in the world :D
           ));
           $user->setName($this->faker->name());
           $user->setRegistrationDate($this->faker->dateTimeBetween('-100 days', '-1 days'));
           $user->setPicture('default_pp_snowtricks.png');

           return $user;
        });

        $manager->flush();
    }
}

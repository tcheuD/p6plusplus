<?php

namespace App\Tests\Entity;

use App\Entity\User;
use DateTime;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testGetEmail(): void
    {
        $user = new User();

        $user->setEmail('email@example.com');

        self::assertSame('email@example.com', $user->getEmail());
    }

    public function testGetUsernameReturnEmail(): void
    {
        $user = new User();

        $user->setEmail('email@example.com');

        self::assertSame('email@example.com', $user->getUsername());
    }

    public function testGetRoles(): void
    {
        $user = new User();

        $user->setRoles(['ROLE_ADMIN']);

        self::assertContains('ROLE_ADMIN', $user->getRoles()) ;
    }

    public function testGetRoleReturnAtleastRoleUser(): void
    {
        $user = new User();

        self::assertContains('ROLE_USER', $user->getRoles()) ;
    }

    public function testGetPassword(): void
    {
        $user = new User();

        $user->setPassword('password');

        self::assertSame('password', $user->getPassword());
    }

    public function testGetFirstName(): void
    {
        $user = new User();

        $user->setFirstname('firstname');

        self::assertSame('firstname', $user->getFirstname());
    }

    public function testGetName(): void
    {
        $user = new User();

        $user->setName('name');

        self::assertSame('name', $user->getName());
    }

    public function testGetCreationDate(): void
    {
        $user = new User();
        $dateTime = new DateTime();

        $user->setRegistrationDate($dateTime);

        self::assertSame($dateTime, $user->getRegistrationDate());
    }

    public function testGetPicture(): void
    {
        $user = new User();

        $user->setPicture('picture.jpg');

        self::assertSame('picture.jpg', $user->getPicture());
    }

    public function testGetPicturePath(): void
    {
        $user = new User();

        $user->setPicture('picture.jpg');

        self::assertSame('images/picture.jpg', $user->getPicturePath());
    }

    public function testGetUserPassIdentity(): void
    {
        $user = new User();

        $user->setUserPassIdentity('pass');

        self::assertSame('pass', $user->getUserPassIdentity());
    }
}

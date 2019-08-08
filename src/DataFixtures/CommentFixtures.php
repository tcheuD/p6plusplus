<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CommentFixtures extends BaseFixture implements DependentFixtureInterface
{
    private static $comments = [
        'cool',
        'Wait, this is not skateboard :(',
        'Q: How many programmers does it take to screw in a light bulb?
        A: None. It\'s a hardware problem.',
        'A web developer walks into a restaurant. He immediately leaves in disgust as the restaurant was laid out in tables.',
        'Elle est trop dure cette figure',
        'Facile',
        'First',
        'How many snowboarders does it take to change a lightbulb?
         27. One to do it, eight to say they could do it better, and the rest to sit on the landing',
        'Je me suis cassé le bras en essayant cette figure',
        'Je me suis cassé la jambe en essayant cette figure',
        'Bonsoir, est-il possible d\'effectuer cette figure avec une planche de surf ?',
    ];

    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(20, 'comments', function ($i) {
            $comment = new Comment();
            $comment->setComment($this->faker->randomElement(self::$comments))
               ->setCommentDate($this->faker->dateTimeBetween('-100 days', '-1 days'))
               ->setTrick($this->getRandomReference('trick'))
               ->setUser($this->getRandomReference('user'));

            return $comment;
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

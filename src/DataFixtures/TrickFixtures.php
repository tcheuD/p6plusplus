<?php

namespace App\DataFixtures;

use App\Entity\Trick;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class TrickFixtures extends BaseFixture implements DependentFixtureInterface
{
    private static $titles = [
        'Big Air',
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

    private static $contents = [
        'Un big air, ou grand saut, est une structure de neige utilisée pour le ski freestyle ou le snowboard. Il s\'agit d\'un tremplin permettant d\'effectuer des figures dans les airs. 
        Un big air est un module de neige en forme de tremplin. Il est composé :
    - d\'une piste descendante pour la prise d\'élan ;
    - d\'un monticule de neige généralement fabriqué par chasse-neige, appelé table ;
    - le monticule est surmonté d\'un tremplin taillé à la pelle, appelé kick ou kicker ;
    - d\'un plat plus ou moins long selon la taille de la table ;
    - d\'une pente descendante qui permet d\'atterrir, appelée généralement réception, récep ou land.

    Le déroulement d\'un saut sur un big air est le suivant :
    - le rideur prend la vitesse qu\'il juge nécessaire sur la piste d\'élan
    - il déclenche son saut lorsqu\'il arrive à l\'extrémité du kick
    - il effectue sa figure en l\'air en passant par-dessus la table
    - enfin il atterrit en douceur sur la récep. Ses vitesses verticale et horizontale sont suffisantes pour que sa trajectoire épouse correctement la pente de la récep, de cette façon l\'atterrissage se fait sans choc, même après une chute de plusieurs mètres.
    source: https://fr.wikipedia.org/wiki/Big_air',
        'Le ollie est une figure consistant a effectuer un saut dans les airs en claquant le "tail" (l\'arrière de la planche.
        Le ollie a été inventé par Alan « Ollie » Gelfand, en 1978, sur les rampes dont il était adepte. Le ollie fut pratiqué en rampe jusqu\'en 1981, lorsque Rodney Mullen entra le premier ollie sur du plat (en flat). Dès lors, les skateboarders ont commencé à se jouer des obstacles de la rue beaucoup plus facilement. En effet, jusqu\'alors, ils devaient sauter en « boneless », une technique bien plus périlleuse, ou en « no comply ».
        source: https://fr.wikipedia.org/wiki/Ollie',
        'En skateboard, il existe deux positions de base : le « goofy » et le « regular ». Chaque skateur à sa position de prédilection, le choix étant instinctif. Un skateur regular roule avec son pied gauche au milieu de sa planche, et son pied droit à l\'arrière, un goofy faisant le contraire. À partir de la position de base, il existe trois variantes possibles : le fakie, le switch, et le nollie.

Cette dernière, qui nous intéresse ici, prescrit que le skateur, à partir de sa position de base, décale ses deux pieds vers l\'avant, le pied arrière passant au milieu et le pied du milieu passant à l\'avant. On pourrait également dire que le skateur roulant en nollie a inversé ses pieds par rapport à sa position de prédilection et roule vers l\'arrière. Ainsi, pour l\'exemple, un skateur regular se trouve en nollie si son pied droit est au milieu de la planche, et son pied gauche à l\'avant.

Rouler et surtout effectuer des figures en position nollie n\'est pas une chose évidente, et est réservé aux skateurs avec un niveau déjà relativement avancé. 
source: https://fr.wikipedia.org/wiki/Nollie',
        'Le switch ollie est une variante du ollie
        Cette technique permet de sauter assez haut. Pour le ollie, les records de hauteur se situent autour de l\'équivalent d\'une dizaine de planches empilées, et à peine moins pour le nollie. Le record du monde officiel mesuré en compétition est détenu par Danny Wainwright pour une hauteur de 44,5 pouces, soit environ 1,13 mètre. Cependant ce même Danny Wainwright a déjà prouvé en public qu\'il était capable d\'atteindre une hauteur de 50 pouces, soit 1,27 mètre, et d\'autres skateurs ont filmé des ollies de hauteur similaire.
         source: https://fr.wikipedia.org/wiki/Ollie',
        'Le One-Two est un trick dans lequel la main avant du rideur saisit le bord du talon derrière son pied arrière.
        source: https://en.wikipedia.org/wiki/List_of_snowboard_tricks',
        'Le AB est un trick dans lequel la main arrière du rideur saisit le côté talon du devant de la planche pour les fixations avant.
        source: https://en.wikipedia.org/wiki/List_of_snowboard_tricks',
        'Le bloody Dracula est un trick dans lequel le rideur saisit la l\'arrière de la planche avec les deux mains. La main arrière saisit la planche comme elle le ferait lors d\'un "tail" classique, la main avant tient la planche derrière le dos du rideur.',
        'La main arrière passe derrère ta jambe arrière pour aller attraper la carre avant entre les fix',
        'La main arrière passe entre les jambes et saisit le bord du talon entre les fixations tandis que la jambe avant est tendu. Le poignet est tourné vers l\'intérieur pour compléter la saisie.
        source: https://en.wikipedia.org/wiki/List_of_snowboard_tricks',
        'Une version plus facile du Japan Air; la main avant saisit le côté de l\'orteil devant le pied avant. Les deux genoux sont alors pliés.
        source: https://en.wikipedia.org/wiki/List_of_snowboard_tricks',
        'La main arrière saisit le bord de l\'orteil devant le pied avant tandis que la jambe arrière est tendu. Certains considèrent également que toute prise de main arrière en avant du pied avant sur le bord des orteils est une prise de type crail, classant celle-ci sur le nez en "nez de mal" ou "vrai crail".
        source: https://en.wikipedia.org/wiki/List_of_snowboard_tricks',
        'Variation avancée d\'un Rocket Air, où les bras sont croisés afin de saisir les côtés opposés du nez de la planche, tandis que la jambe arrière est tendu et que la jambe avant est repliée vers le haut.
        source: https://en.wikipedia.org/wiki/List_of_snowboard_tricks',
    ];

    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(12, 'trick', function ($i) {
            $trick = new Trick();
            $title = self::$titles[$i];
            $content = self::$contents[$i];
            $trick->setTitle($title)
                ->setCreationDate($this->faker->dateTimeBetween('-100 days', '-1 days'))
                ->setCategory($this->getRandomReference('category'))
                ->setCreatedBy($this->getRandomReference('user'))
                ->setContent($content)
                ->setSlug(strtolower(str_replace(' ', '-', $title)))
                ->setMainPicture('images/'.strtolower(str_replace(' ', '-', $title)).'.jpg');

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

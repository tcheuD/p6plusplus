<?php

namespace App\Controller;

use App\Entity\Trick;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TrickController extends AbstractController
{
    /**
     * @Route("/trick/{slug}", name="show_trick")
     */
    public function showTrick($slug)
    {
        $trick = $this->getDoctrine()
            ->getRepository(Trick::class)
            ->findBySlug($slug);

        return $this->render('trick/show.html.twig', [
            'trick' => $trick
        ]);
    }

    /**
     * @Route("/", name="app_homepage")
     */
    public function showTricks()
    {
        $tricks = $this->getDoctrine()
            ->getRepository(Trick::class)
            ->findAll();

        return $this->render('trick/index.html.twig', [
           'tricks' => $tricks
        ]);
    }
}

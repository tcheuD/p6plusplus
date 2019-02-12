<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Repository\CommentRepository;
use App\Repository\PictureRepository;
use App\Repository\TrickRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class TrickController extends AbstractController
{
    /**
     * @Route("/trick/{slug}", name="show_trick")
     */
    public function showTrick(TrickRepository $trick, CommentRepository $comment, PictureRepository $picture,$slug)
    {
        $trick = $this->getDoctrine()
            ->getRepository(Trick::class)
            ->findBySlug($slug);


        return $this->render('trick/show.html.twig', [
            'trick' => $trick,
        ]);
    }
}

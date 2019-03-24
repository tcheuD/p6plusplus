<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Trick;
use App\Form\CommentType;
use App\Form\Handler\AddCommentHandler;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class TrickController extends BaseController
{
    /**
     * @Route("/trick/{slug}/{page}", requirements={"page" = "\d+"}, name="show_trick")
     */
    public function showTrick($slug, $page, Request $request, EntityManagerInterface $em)
    {
        $trick = $this->getDoctrine()
            ->getRepository(Trick::class)
            ->findBySlug($slug);

        $form = $this->createForm(CommentType::class);
        $form->handleRequest($request);

        $comments = $this->getDoctrine()
            ->getRepository(Comment::class)
            ->findByTrickAndPaginate($trick, $page, 5 );

        $pagination = array(
            'page' => $page,
            'nbPages' => ceil(count($comments) / 5),
            'nomRoute' => 'show_trick',
            'paramsRoute' => array()
        );

        if ($form->isSubmitted() && $form->isValid()) {

            $commentHandler = new AddCommentHandler();
            $comment = $commentHandler->handle($form, $trick, $this->getUser());

            if ($comment) {
                $em->persist($comment);
                $em->flush();
                $this->addFlash('success', 'Le commentaire a bien été ajouté');
            }
        }


        return $this->render('trick/show.html.twig', [
            'trick' => $trick,
            'commentForm' => $form->createView(),
            'comments' => $comments,
            'pagination' => $pagination

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

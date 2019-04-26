<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Trick;
use App\Form\CommentType;
use App\Form\Handler\AddCommentHandler;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
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
    public function showTricks(EntityManagerInterface $em)
    {
        $tricks = $this->getDoctrine()
            ->getRepository(Trick::class)
            ->findAllAndPaginate(1, 15);

        $queryBuilder = $em->createQueryBuilder();
        $queryBuilder->select('COUNT(u.id)')
            ->from(Trick::class, 'u');
        $query = $queryBuilder->getQuery();
        $numberOfTricks = $query->getSingleScalarResult();


        return $this->render('trick/index.html.twig', [
           'tricks' => $tricks,
            'numberOfTricks' => $numberOfTricks
        ]);
    }

    /**
     * @Route("/ajax2", name="app_ajax2")
     */
    public function ajax(Request $request)
    {

        if ($request->isXmlHttpRequest()){

            $lol = $request->request->get('row');
            intval($lol);

            $tricks = $this->getDoctrine()
                ->getRepository(Trick::class)
                ->findAllAndPaginate(2, 15 );


            $c = count($tricks);
            foreach ($tricks as $post) {
                dump($post);
            }

            $jsonData = array();
            $idx = 0;
            /** @var  $trick Trick */
            foreach($tricks as $trick) {
                $temp = array(
                    'title' => $trick->getTitle(),
                    'mainPicture' => $trick->getMainPicture(),
                    'slug' => $trick->getSlug(),
                );
                $jsonData[$idx++] = $temp;
            }

                return new JsonResponse($jsonData);
        }

        return new JsonResponse("This is not an ajax request");
    }
}

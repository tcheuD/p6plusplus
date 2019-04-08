<?php

namespace App\Controller;

use App\Entity\Picture;
use App\Entity\Trick;
use App\Form\AddPictureFormType;
use App\Form\EditTrickFormType;
use App\Form\Handler\AddTrickHandler;
use App\Form\Handler\EditTrickHandler;
use App\Form\TrickFormType;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use http\Env\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TrickAdminController
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 */
class TrickAdminController extends BaseController
{
    /**
     * @Route("/trick/new", name="trick_admin")
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function new(EntityManagerInterface $em, Request $request, FileUploader $fileUploader)
    {

        $trick = new Trick();

        $form = $this->createForm(TrickFormType::class, $trick );
        $form->handleRequest($request);

        $trickHandler = new AddTrickHandler();

        if ($trickHandler->handle($form, $trick, $this->getUser(), $fileUploader))
        {
            $em->persist($trick);
            $em->flush();

            $this->addFlash('success', 'La figure a bien été ajoutée');

            return $this->redirectToRoute('app_homepage');
        }
        return $this->render('trick_admin/new.html.twig', [
            'trickForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("trick/edit/{slug}", name="edit_trick")
     */
    public function edit(Trick $trick, Request $request, EntityManagerInterface $em, FileUploader $fileUploader)
    {

        $form = $this->createForm(EditTrickFormType::class, $trick);
        $form->handleRequest($request);

        //dd($form["mainPicture"]);
        $trickHandler = new EditTrickHandler();

        if ($trickHandler->handle($form, $trick, $this->getUser(), $fileUploader))
        {
            $em->persist($trick);
            $em->flush();

            $this->addFlash('success', 'La figure a bien été mise à jour');

            return $this->redirectToRoute('app_homepage');
        }
        return $this->render('trick_admin/edit.html.twig', [
            'trickForm' => $form->createView(),
            'trick' => $trick,
        ]);
    }

    /**
     * @Route("/trick/pic", name="trick_pic")
     */
    public function addPicture(EntityManagerInterface $em, Request $request, FileUploader $fileUploader)
    {
        //TODO: HandlePictureForm

        $form = $this->createForm(AddPictureFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $picturesCollection = $form['pictures']->getData();
            foreach ($picturesCollection as $b => $picture) {

                $filename = $fileUploader->upload($form['pictures'][$b]['url']->getData());

                /** @var Picture $picture */
                $picture->setAuthor($this->getUser());
                $picture->setCreationDate(new \DateTime());
                $picture->setUrl($filename);
                $picture->setNumber(1);

                $em->persist($picture);
            }
                $em->flush();

            $this->addFlash('success', 'Le ou les images ont bien été ajoutée');

            return $this->redirectToRoute('trick_pic');
        }

        return $this->render('trick_admin/addPicture.html.twig', [
            'trickForm' => $form->createView(),
        ]);

    }

    /**
     * @Route("/ajax", name="app_ajax")
     */
    public function ajax(Request $request, FileUploader $fileUploader, EntityManagerInterface $em)
    {

        if ($request->isXmlHttpRequest()){

            $picture = $this->getDoctrine()
                ->getRepository(Picture::class)
                ->findOneById($request->request->get('picId'));


            $file = $request->files->get('file');
            $filename = $fileUploader->upload($file);

            if ($picture) {
                $picture->setAuthor($this->getUser());
                $picture->setUrl($filename);
                $picture->setCreationDate(new \DateTime());
                $picture->setFilename($file->getClientOriginalName());

                $em->persist($picture);
                $em->flush();
            }


            return new JsonResponse($filename);
        }

        return new JsonResponse("This is not an ajax request");
    }
}

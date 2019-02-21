<?php

namespace App\Controller;

use App\Entity\Picture;
use App\Form\PictureFormType;
use App\Form\TrickFormType;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TrickAdminController extends AbstractController
{
    /**
     * @Route("/trick/new", name="trick_admin")
     */
    public function new(EntityManagerInterface $em, Request $request)
    {
        $form = $this->createForm(TrickFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $trick = $form->getData();
            $trick->setCreationDate(new \DateTime());
            $trick->setSlug(strtolower(str_replace(' ', '-', $trick->getTitle())));
            $trick->setCreatedBy($this->getUser());

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
     * @Route("/trick/pic", name="trick_pic")
     */
    public function addPicture(EntityManagerInterface $em, Request $request, FileUploader $fileUploader)
    {
        $form = $this->createForm(PictureFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isSubmitted()) {

            $data = $form->getData();

            $filename = $fileUploader->upload($data['image']);

            $picture = new Picture();
            $picture->setCreationDate(new \DateTime());
            $picture->setAuthor($this->getUser());
            $picture->setUrl($filename);
            $picture->setNumber(1);

            $em->persist($picture);
            $em->flush();

        }

        return $this->render('trick_admin/addPicture.html.twig', [
            'trickForm' => $form->createView(),
        ]);

    }
}

<?php

namespace App\Controller;

use App\Entity\Picture;
use App\Entity\Trick;
use App\Form\Handler\AddTrickHandler;
use App\Form\PictureFormType;
use App\Form\TrickFormType;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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
    public function new(EntityManagerInterface $em, Request $request)
    {
        $trick = new Trick();

        $form = $this->createForm(TrickFormType::class, $trick);
        $form->handleRequest($request);

        $trickHandler = new AddTrickHandler();

        if ($trickHandler->handle($form, $trick, $this->getUser()))
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
     * @Route("/trick/pic", name="trick_pic")
     */
    public function addPicture(EntityManagerInterface $em, Request $request, FileUploader $fileUploader)
    {

        //TODO: HandlePictureForm

        $form = $this->createForm(PictureFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isSubmitted()) {

            $data = $form->getData();

            $filename = $fileUploader->upload($data['url']);

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

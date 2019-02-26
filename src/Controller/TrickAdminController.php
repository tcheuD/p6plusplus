<?php

namespace App\Controller;

use App\Entity\Picture;
use App\Entity\Trick;
use App\Form\PictureFormType;
use App\Form\TrickFormType;
use App\Service\FileUploader;
use App\Validator\UniqueVideo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TrickAdminController
 * @package App\Controller
 */
class TrickAdminController extends AbstractController
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
        if ($form->isSubmitted() && $form->isValid()) {

            $trick = $form->getData();

            $trick->setCreationDate(new \DateTime());
            $trick->setSlug(strtolower(str_replace(' ', '-', $trick->getTitle())));
            $trick->setCreatedBy($this->getUser());


            if (!is_null($form->getData()->getVideos())) {
                $videosCollection = $form->getData()->getVideos()->toArray();
                foreach ($videosCollection as $b => $video) {
                    preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $video->getUrl(), $match);
                    $videos[] = $video->getUrl();
                    $video->setNumber(1);
                    $video->setTrick($trick);
                    $video->setCreationDate(new \DateTime());
                    $video->setIdentif($match[1]);
                    $video->setAuthor($trick->getCreatedBy());
                }
            }

            if (!is_null($form->getData()->getPictures())) {
                $picturesCollection = $form->getData()->getPictures()->toArray();
                foreach ($picturesCollection as $b => $picture) {
                    $videos[] = $picture->getUrl();
                    $picture->setAuthor($trick->getCreatedBy());
                    $picture->setTrick($trick);
                }
            }

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

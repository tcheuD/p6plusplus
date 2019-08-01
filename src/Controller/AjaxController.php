<?php

namespace App\Controller;


use App\Entity\Picture;
use App\Entity\Trick;
use App\Repository\PictureRepository;
use App\Repository\TrickRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AjaxController extends BaseController
{
    /**
     * @Route("/load-more-tricks", name="app_load_more_tricks")
     */
    public function loadMoreTricks(Request $request)
    {

        if ($request->isXmlHttpRequest()){

            $tricks = $this->getDoctrine()
                ->getRepository(Trick::class)
                ->findAllAndPaginate(2, 15 );

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

    /**
     * @Route("/ajax-upload-picture", name="app_ajax_upload_picture")
     */
    public function ajaxUploadPicture(Request $request, FileUploader $fileUploader, EntityManagerInterface $em, PictureRepository $pictureRepository, TrickRepository $trickRepository)
    {

        if ($request->isXmlHttpRequest()){

            $trick = $trickRepository->findBySlug($request->request->get('trickSlug'));

            $file = $request->files->get('file');
            $filename = $fileUploader->upload($file);

            $picture = new Picture();
            $picture->setAuthor($this->getUser());
            $picture->setUrl($filename);
            $picture->setCreationDate(new \DateTime());
            $picture->setFilename($file->getClientOriginalName());
            $picture->setNumber(1);
            if ($trick) {
                $picture->addTrick($trick);
                $em->persist($picture);
                $em->flush();
            }
            else {
                $em->persist($picture);
            }

            return new JsonResponse($filename);
        }

        return new JsonResponse("This is not an ajax request");
    }

    /**
     * @Route("/ajax-delete-trick", name="app_ajax_delete-trick")
     */
    public function ajaxDeleteTrick(Request $request, EntityManagerInterface $em)
    {

        if ($request->isXmlHttpRequest()){

            $slug = $request->request->get('slug');

            $trick = $this->getDoctrine()
                ->getRepository(Trick::class)
                ->findBySlug($slug);

            if ($trick) {
                $em->persist($trick);
                $em->remove($trick);
                $em->flush();
            }

            $this->addFlash('success', 'La figure a bien été supprimée');

            return $this->redirectToRoute('app_homepage');
        }

        return new JsonResponse("This is not an ajax request");
    }

}
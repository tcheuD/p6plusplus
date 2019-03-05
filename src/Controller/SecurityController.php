<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Handler\UserRegistrationHandler;
use App\Form\UserRegistrationFormType;
use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends BaseController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {

    }

    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, FileUploader $fileUploader)
    {

        $user = new User();

        $form = $this->createForm(UserRegistrationFormType::class, $user);

        $form->handleRequest($request);

        $userRegistrationHandler = new UserRegistrationHandler();

        if ($userRegistrationHandler->handle($form, $user, $passwordEncoder, $fileUploader))
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('app_homepage');

        }

        return $this->render('security/register.html.twig', [
            'registrationForm' => $form->createView()
        ]);
    }
}

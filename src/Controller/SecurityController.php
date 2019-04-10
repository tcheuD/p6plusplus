<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ForgotPasswordFormType;
use App\Form\Handler\ResetPasswordHandler;
use App\Form\Handler\UserRegistrationHandler;
use App\Form\ResetPasswordFormType;
use App\Form\UserRegistrationFormType;
use App\Repository\UserRepository;
use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class SecurityController
 * @package App\Controller
 */
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

    /**
     * @Route("/forgot-password", name="app_forgot_password")
     * @param Request $request
     * @param \Swift_Mailer $mailer
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function forgotPassword(Request $request, \Swift_Mailer $mailer)
    {
        $form = $this->createForm(ForgotPasswordFormType::class);
        $form->handleRequest($request);

        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findByMail($form['email']->getData());

        if ($user) {
            $bytes = random_bytes(10);
            $int = bin2hex($bytes);

            $user->setUserPassIdentity($int);
            $user->getEmail();

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $message = (new \Swift_Message('SnowTricks | Réinitialisation de votre mot passe'))
                ->setFrom('contact@damienchedan.fr')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(
                        'mail.html.twig',
                        [
                            'name' => $name = 'lol',
                            'pass' => $int]
                    ),
                    'text/html'
                )
                ;

            $mailer->send($message);
        }


        return $this->render('security/forgotPassword.html.twig', [
            'forgotPasswordForm' => $form->createView()
        ]);

    }

    /**
     * @Route("/reset-password/{pass}", name="app_reset_password")
     * @param Request $request
     * @param $pass
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function resetPassword(Request $request, $pass, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findByPassIdentity($pass);

        if ($user) {
            $form = $this->createForm(ResetPasswordFormType::class);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $resetPasswordHandler = new ResetPasswordHandler();

                $user = $resetPasswordHandler->handle($form, $passwordEncoder, $user);

                if ($user) {
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($user);
                    $em->flush();
                    $this->addFlash('success', 'Votre mot de passe a bien été modifié !');
                }
            }
            return $this->render('security/resetPassword.html.twig', [
                'resetPasswordForm' => $form->createView(),
                ''
            ]);
        }

        return $this->redirectToRoute('app_homepage');


    }
}

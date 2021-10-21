<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use App\Repository\UserRepository;
use App\Security\AppAuthenticator;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    private VerifyEmailHelperInterface $verifyEmailHelper;
    private AppAuthenticator $authenticator;
    private GuardAuthenticatorHandler $guardHandler;

    public function __construct(VerifyEmailHelperInterface $emailHelper, AppAuthenticator $authenticator,
GuardAuthenticatorHandler $guardHandler)
    {
        $this->verifyEmailHelper = $emailHelper;
        $this->authenticator = $authenticator;
        $this->guardHandler = $guardHandler;
    }

    /**
     * @Route("/change-password", name="registration_change_password")
     */
    public function changePassword(Request $request, UserRepository $userRepository): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('class_list');
        }

        $id = $request->get('id');
        if (null === $id) {
            return $this->redirectToRoute('class_list');
        }

        $user = $userRepository->find($id);
        if (null === $user) {
            return $this->redirectToRoute('class_list');
        }

        try {
            $this->verifyEmailHelper->validateEmailConfirmation($request->getUri(), $user->getId(), $user->getEmail());
        } catch (VerifyEmailExceptionInterface $e) {
            return $this->redirectToRoute('class_list');
        }

        $changePasswordForm = $this->createForm(ChangePasswordType::class, $user);
        $changePasswordForm->handleRequest($request);
        if ($changePasswordForm->isSubmitted() && $changePasswordForm->isValid()) {
            $user->setIsVerified(true);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $this->authenticator,
                'main'
            );
        }

        return $this->render('registration/change_password.html.twig', [
            'change_password_form' => $changePasswordForm->createView()
        ]);
    }
}

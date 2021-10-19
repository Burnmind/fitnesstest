<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    private VerifyEmailHelperInterface $verifyEmailHelper;

    public function __construct(VerifyEmailHelperInterface $emailHelper, MailerInterface $mailer)
    {
        $this->verifyEmailHelper = $emailHelper;
    }

    /**
     * @Route("/change-password", name="registration_change_password_route")
     */
    public function changePassword(Request $request, UserRepository $userRepository): Response
    {
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

        return $this->render('registration/change_password.html.twig', [
            'change_password_form' => $this->createForm(ChangePasswordType::class, $user)->createView()
        ]);
    }
}

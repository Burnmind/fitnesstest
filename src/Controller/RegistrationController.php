<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    private VerifyEmailHelperInterface $verifyEmailHelper;
    private EntityManagerInterface $entityManager;
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(VerifyEmailHelperInterface $emailHelper, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->verifyEmailHelper = $emailHelper;
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
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

        $changePasswordForm = $this->createForm(ChangePasswordType::class, $user);
        $changePasswordForm->handleRequest($request);
        if ($changePasswordForm->isSubmitted() && $changePasswordForm->isValid()) {
            $password = $this->passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/change_password.html.twig', [
            'change_password_form' => $changePasswordForm->createView()
        ]);
    }
}

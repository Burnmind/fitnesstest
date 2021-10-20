<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/profile", name="profile")
     */
    public function index(Request $request, NotifierInterface $notifier): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('class_list');
        }


        $changePasswordForm = $this->createForm(ChangePasswordType::class, $user);
        $changePasswordForm->handleRequest($request);
        if ($changePasswordForm->isSubmitted() && $changePasswordForm->isValid()) {
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $notifier->send(new Notification('Пароль успешно сменен!', ['browser']));
        }

        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
            'change_password_form' => $changePasswordForm->createView()
        ]);
    }
}

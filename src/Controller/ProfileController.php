<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="profile")
     */
    public function index(Request $request, NotifierInterface $notifier): Response
    {
        $user = $this->getUser();
        $changePasswordForm = $this->createForm(ChangePasswordType::class, $user);
        $changePasswordForm->handleRequest($request);
        if ($changePasswordForm->isSubmitted() && $changePasswordForm->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $notifier->send(new Notification('Пароль успешно сменен!', ['browser']));
        }

        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
            'change_password_form' => $changePasswordForm->createView()
        ]);
    }
}

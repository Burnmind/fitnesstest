<?php

namespace App\Controller;

use App\Entity\GroupFitnessClasses;
use App\Entity\Subscription;
use App\Entity\User;
use App\Form\SubscriptionType;
use App\Repository\GroupFitnessClassesRepository;
use App\Repository\SubscriptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Routing\Annotation\Route;

class FitnessClubController extends AbstractController
{
    /**
     * @Route("/", name="class_list")
     */
    public function index(GroupFitnessClassesRepository $groupFitnessClassesRepository): Response
    {
        return $this->render('fitness_club/index.html.twig', [
            'group_fitness_classes' => $groupFitnessClassesRepository->findAll()
        ]);
    }

    /**
     * @Route("/class/{id}", name="class_detail")
     */
    public function detail(GroupFitnessClasses $groupFitnessClass): Response
    {
        return $this->render('fitness_club/detail.html.twig', [
            'group_fitness_class' => $groupFitnessClass
        ]);
    }

    // Вынес формы т.к. экшн детальной получился довольно "толстым"
    public function subscriptionForm(GroupFitnessClasses $groupFitnessClass, Request $request, NotifierInterface $notifier)
    {
        /** @var User|null $user */
        $user = $this->getUser();
        if ($user) {
            $entityManager = $this->getDoctrine()->getManager();
            $subscription = $entityManager->getRepository(Subscription::class)
                ->findOneBy([
                    'subscribedUser' => $user,
                    'groupFitnessClass' => $groupFitnessClass
                ]);

            if (empty($subscription)) {
                $subscription = new Subscription();
                $subscription->setSubscribedUser($user);
                $subscription->setGroupFitnessClass($groupFitnessClass);
            }

            $subscriptionForm = $this->createForm(SubscriptionType::class, $subscription);
            $subscriptionForm->handleRequest($request);
            if ($subscriptionForm->isSubmitted() && $subscriptionForm->isValid()) {
                // если есть id значит способ связи существует в базе и это подписка
                if ($subscription->getContactType()->getId()) {
                    $entityManager->persist($subscription);
                    $entityManager->flush();

                    $notifier->send(new Notification('Подписка оформлена!', ['browser']));
                } else {
                    // в противном случае это отписка
                    $entityManager->remove($subscription);
                    $entityManager->flush();

                    $notifier->send(new Notification('Подписка отменена!', ['browser']));
                }
            }
        }

        return $this->render('fitness_club/forms/subscription.html.twig', [
            'subscription_form' => $user ? $subscriptionForm->createView() : null
        ]);
    }
}

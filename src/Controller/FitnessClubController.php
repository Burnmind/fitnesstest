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
    public function detail(Request $request, GroupFitnessClasses $groupFitnessClass, NotifierInterface $notifier): Response
    {
        /** @var User $user */
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
                // обработать отписку

                $entityManager->persist($subscription);
                $entityManager->flush();

                $notifier->send(new Notification('Подписка оформлена!', ['browser']));
            }
        }

        return $this->render('fitness_club/detail.html.twig', [
            'group_fitness_class' => $groupFitnessClass,
            'subscription_form' => $user ? $subscriptionForm->createView() : null
        ]);
    }
}

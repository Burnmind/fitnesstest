<?php

namespace App\Controller;

use App\Entity\GroupFitnessClasses;
use App\Repository\GroupFitnessClassesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FitnessClubController extends AbstractController
{
    /**
     * @Route("/", name="class_list")
     */
    public function index(GroupFitnessClassesRepository $groupFitnessClassesRepository): Response
    {
        return $this->render('fitness_club/index.html.twig', [
            'groupFitnessClasses' => $groupFitnessClassesRepository->findAll()
        ]);
    }

    /**
     * @Route("/class/{id}", name="class_detail")
     */
    public function detail(GroupFitnessClasses $groupFitnessClass): Response
    {
        return $this->render('fitness_club/detail.html.twig', [
            'groupFitnessClass' => $groupFitnessClass
        ]);
    }
}

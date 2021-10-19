<?php

namespace App\Controller\Admin;

use App\Entity\GroupFitnessClasses;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Fitnessclub');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('На сайт', 'fa fa-home', 'class_list');
        yield MenuItem::linkToCrud('Список групповых занятий', 'fas fa-list', GroupFitnessClasses::class);
        yield MenuItem::linkToCrud('Пользователи', 'fas fa-users', User::class);
    }
}

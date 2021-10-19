<?php

namespace App\Controller\Admin;

use App\Entity\GroupFitnessClasses;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class GroupFitnessClassesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return GroupFitnessClasses::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}

<?php

namespace App\Controller\Admin;

use App\Entity\GroupFitnessClasses;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class GroupFitnessClassesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return GroupFitnessClasses::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            TextField::new('couchName'),
            TextEditorField::new('description'),
            // NumberField::new('subscriptions')->formatValue(fn($subscriptions) => $subscriptions->count()),
        ];
    }

}

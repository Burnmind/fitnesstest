<?php

namespace App\Controller\Admin;

use App\Entity\Sex;
use App\Entity\User;
use App\Repository\SexRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\BatchActionDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\Response;

class UserCrudController extends AbstractCrudController
{
    private SexRepository $sexRepository;

    public function __construct(SexRepository $sexRepository)
    {
        $this->sexRepository = $sexRepository;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield ImageField::new('photo')
            ->setBasePath('uploads/images/')
            ->setUploadDir('public/uploads/images/');
        yield TextField::new('username');
        yield TextField::new('fullName');

        if ($pageName == Crud::PAGE_INDEX || $pageName == Crud::PAGE_NEW) {
            yield EmailField::new('email');
        }

        yield TelephoneField::new('phone');
        yield DateField::new('dateOfBirth');
        yield AssociationField::new('sex')->setRequired(true);
        yield BooleanField::new('isBlocked');
        yield BooleanField::new('isVerified');
    }

    /**
     * @param EntityManagerInterface $entityManager
     * @param User $entityInstance
     * @throws \Exception
     */
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        // Пароль не может быть пустым. Ставим случайный набор символов пользователь его сменит на свой.
        $entityInstance->setPassword(bin2hex(random_bytes(16)));

        parent::persistEntity($entityManager, $entityInstance);
    }
}

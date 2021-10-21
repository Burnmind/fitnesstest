<?php

namespace App\Form;

use App\Entity\Subscription;
use App\Entity\SubscriptionContact;
use App\Repository\SubscriptionContactRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubscriptionType extends AbstractType
{
    private SubscriptionContactRepository $contactRepository;

    public function __construct(SubscriptionContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $contactTypeChoicesData = [
            (new SubscriptionContact())->setName('Без подписки'),
        ];

        foreach ($this->contactRepository->findAll() as $contact) {
            $contactTypeChoicesData[$contact->getId()] = $contact;
        }

        $builder
            ->add('contactType', ChoiceType::class, [
                'choices' => $contactTypeChoicesData,
                'label' => 'Варинант подписки',
                'choice_label' => 'name',
                'choice_value' => 'id',
                'expanded' => true
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Подписаться'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Subscription::class,
        ]);
    }
}

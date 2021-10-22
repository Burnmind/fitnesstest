<?php

namespace App\Form;

use App\Entity\NotificationMessage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserNotificationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('emailMessage', TextareaType::class, [
                'label' => 'Email сообщение:'
            ])
            ->add('smsMessage', TextareaType::class, [
                'label' => 'СМС сообщение:'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Отправить'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NotificationMessage::class,
        ]);
    }
}

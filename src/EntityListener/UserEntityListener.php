<?php


namespace App\EntityListener;


use App\Entity\User;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Bridge\Twig\Mime\NotificationEmail;
use Symfony\Component\Mailer\MailerInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

class UserEntityListener
{
    private VerifyEmailHelperInterface $verifyEmailHelper;
    private MailerInterface $mailer;

    public function __construct(VerifyEmailHelperInterface $emailHelper, MailerInterface $mailer)
    {
        $this->verifyEmailHelper = $emailHelper;
        $this->mailer = $mailer;
    }

    /**
     * Отправка письма после добавления пользователя с сылкой на форму смены пароля
     *
     * @param User $user
     * @param LifecycleEventArgs $event
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function postPersist(User $user, LifecycleEventArgs $event)
    {
        $signatureComponents =  $this->verifyEmailHelper->generateSignature(
            'registration_change_password_route',
            $user->getId(),
            $user->getEmail(),
            ['id' => $user->getId()]
        );

        $email = new NotificationEmail();
        $email->from('noreply@fitness.com');
        $email->to($user->getEmail());
        $email->htmlTemplate('emails/confirmation_email.html.twig');
        $email->context(['signedUrl' => $signatureComponents->getSignedUrl()]);

        $this->mailer->send($email);
    }
}

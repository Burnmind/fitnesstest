<?php


namespace App\MessageHandler;


use App\Entity\GroupFitnessClasses;
use App\Entity\User;
use App\Message\NotificationEmail;
use App\Repository\GroupFitnessClassesRepository;
use App\Repository\UserRepository;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

class NotificationEmailHandler extends AbstractNotificationHandler
{
    private MailerInterface $mailer;

    public function __construct(UserRepository $userRepository, GroupFitnessClassesRepository $groupFitnessClassesRepository,
                                MailerInterface $mailer)
    {
        $this->mailer = $mailer;

        parent::__construct($userRepository, $groupFitnessClassesRepository);
    }

    public function __invoke(NotificationEmail $message)
    {
        $this->startHandling($message);
    }

    /**
     * @param User $user
     * @param GroupFitnessClasses $groupFitnessClass
     * @param string $textMessage
     *
     * @throws TransportExceptionInterface
     */
    protected function send(User $user, GroupFitnessClasses $groupFitnessClass, string $textMessage)
    {
        $email = new \Symfony\Bridge\Twig\Mime\NotificationEmail();
        $email->from('noreply@fitness.com');
        $email->to($user->getEmail());
        $email->htmlTemplate('emails/notification_email.html.twig');
        $email->context([
            'groupFitnessClass' => $groupFitnessClass,
            'message' => $textMessage
        ]);

        $this->mailer->send($email);
    }
}

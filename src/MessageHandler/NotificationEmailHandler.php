<?php


namespace App\MessageHandler;


use App\Entity\GroupFitnessClasses;
use App\Entity\User;
use App\Repository\GroupFitnessClassesRepository;
use App\Repository\UserRepository;
use \Symfony\Bridge\Twig\Mime\NotificationEmail;
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

    /**
     * @param User $user
     * @param GroupFitnessClasses $groupFitnessClass
     * @param string $textMessage
     *
     * @throws TransportExceptionInterface
     */
    protected function send(User $user, GroupFitnessClasses $groupFitnessClass, string $textMessage)
    {
        $email = new NotificationEmail();
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

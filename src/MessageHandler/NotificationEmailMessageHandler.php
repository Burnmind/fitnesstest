<?php


namespace App\MessageHandler;


use App\Message\NotificationEmailMessage;
use App\Repository\GroupFitnessClassesRepository;
use App\Repository\UserRepository;
use Symfony\Bridge\Twig\Mime\NotificationEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

class NotificationEmailMessageHandler
{
    private UserRepository $userRepository;
    private GroupFitnessClassesRepository $groupFitnessClassesRepository;
    private MailerInterface $mailer;

    public function __construct(UserRepository $userRepository, GroupFitnessClassesRepository $groupFitnessClassesRepository, MailerInterface $mailer)
    {
        $this->userRepository = $userRepository;
        $this->groupFitnessClassesRepository = $groupFitnessClassesRepository;
        $this->mailer = $mailer;
    }

    /**
     * @param NotificationEmailMessage $message
     * @throws TransportExceptionInterface
     */
    public function __invoke(NotificationEmailMessage $message)
    {
        $user = $this->userRepository->find($message->getUserId());
        $groupFitnessClass = $this->groupFitnessClassesRepository->find($message->getMessage());

        if (empty($user) || empty($groupFitnessClass)) {
            return;
        }

        $textMessage = str_replace(
            ['%name%', '%dateOfBirth%', '%email%', '%phone%'],
            [$user->getFullName(), $user->getDateOfBirth()->format('d.m.Y'), $user->getEmail(), $user->getPhone()],
            $message->getMessage()
        );

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

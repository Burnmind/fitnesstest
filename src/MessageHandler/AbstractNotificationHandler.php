<?php


namespace App\MessageHandler;


use App\Entity\GroupFitnessClasses;
use App\Entity\User;
use App\Message\NotificationInterface;
use App\Repository\GroupFitnessClassesRepository;
use App\Repository\UserRepository;
use Symfony\Component\Messenger\Exception\UnrecoverableMessageHandlingException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

abstract class AbstractNotificationHandler implements MessageHandlerInterface
{
    private UserRepository $userRepository;
    private GroupFitnessClassesRepository $groupFitnessClassesRepository;

    public function __construct(UserRepository $userRepository, GroupFitnessClassesRepository $groupFitnessClassesRepository)
    {
        $this->userRepository = $userRepository;
        $this->groupFitnessClassesRepository = $groupFitnessClassesRepository;
    }

    /**
     * @param NotificationInterface $message
     */
    public function startHandling(NotificationInterface $message)
    {
        $user = $this->userRepository->findOneBy([
            'id' => $message->getUserId(),
            'isBlocked' => false
        ]);
        $groupFitnessClass = $this->groupFitnessClassesRepository->find($message->getClassId());

        // Если нет юзера или занятия кидаем исключение избегающее повторного отправления
        if (empty($user) || empty($groupFitnessClass)) {
            throw new UnrecoverableMessageHandlingException();
        }

        $textMessage = str_replace(
            ['%name%', '%dateOfBirth%', '%email%', '%phone%'],
            [$user->getFullName(), $user->getDateOfBirth()->format('d.m.Y'), $user->getEmail(), $user->getPhone()],
            $message->getMessage()
        );

        $this->send($user, $groupFitnessClass, $textMessage);
    }

    abstract protected function send(User $user, GroupFitnessClasses $groupFitnessClass, string $textMessage);
}

<?php


namespace App\Message;


use App\Entity\Subscription;

class NotificationEmail implements NotificationInterface
{
    private int $userId;
    private int $classId;
    private string $message;

    public function __construct(Subscription $subscription, string $message)
    {
        $this->userId = (int)$subscription->getSubscribedUser()->getId();
        $this->classId = (int)$subscription->getGroupFitnessClass()->getId();
        $this->message = $message;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getClassId(): int
    {
        return $this->classId;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}

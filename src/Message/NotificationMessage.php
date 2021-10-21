<?php


namespace App\Message;


class NotificationMessage
{
    private int $userId;
    private string $message;
    private string $channel;

    public function __construct(int $userId, string $message, string $channel)
    {
        $this->userId = $userId;
        $this->message = $message;
        $this->channel = $channel;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getChannel(): string
    {
        return $this->channel;
    }
}

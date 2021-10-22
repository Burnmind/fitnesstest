<?php


namespace App\Entity;


class NotificationMessage
{
    private string $emailMessage;
    private string $smsMessage;

    public function getEmailMessage(): string
    {
        return $this->emailMessage;
    }

    public function setEmailMessage(string $emailMessage): void
    {
        $this->emailMessage = $emailMessage;
    }

    public function getSmsMessage(): string
    {
        return $this->smsMessage;
    }

    public function setSmsMessage(string $smsMessage): void
    {
        $this->smsMessage = $smsMessage;
    }
}

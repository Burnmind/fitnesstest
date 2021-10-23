<?php


namespace App\Entity;


class NotificationMessage
{
    private string $emailMessage = '';
    private string $smsMessage = '';

    public function getEmailMessage(): string
    {
        return $this->emailMessage;
    }

    public function setEmailMessage($emailMessage): void
    {
        $this->emailMessage = (string)$emailMessage;
    }

    public function getSmsMessage(): string
    {
        return $this->smsMessage;
    }

    public function setSmsMessage($smsMessage): void
    {
        $this->smsMessage = (string)$smsMessage;
    }
}

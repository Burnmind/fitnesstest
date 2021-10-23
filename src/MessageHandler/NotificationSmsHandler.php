<?php


namespace App\MessageHandler;


use App\Entity\GroupFitnessClasses;
use App\Entity\User;

class NotificationSmsHandler extends AbstractNotificationHandler
{
    public function send(User $user, GroupFitnessClasses $groupFitnessClass, string $textMessage)
    {
        // TODO: Implement __invoke() method.
    }
}

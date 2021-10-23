<?php


namespace App\Message;


interface NotificationInterface
{
    /**
     * id подписавшегося пользователя
     *
     * @return int
     */
    public function getUserId(): int;

    /**
     * id занятия на которое подписан пользователь
     *
     * @return int
     */
    public function getClassId(): int;

    /**
     * Сообщение для пользователя
     *
     * @return string
     */
    public function getMessage(): string;
}

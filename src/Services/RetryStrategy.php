<?php


namespace App\Services;


use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Retry\RetryStrategyInterface;

class RetryStrategy implements RetryStrategyInterface
{
    /**
     * Бесконечные попытки на повторную отправку
     *
     * @param Envelope $message
     * @return bool
     */
    public function isRetryable(Envelope $message): bool
    {
        return true;
    }

    /**
     * 10 минут в миллисекундах
     */
    public function getWaitingTime(Envelope $message): int
    {
        return 600000;
    }
}

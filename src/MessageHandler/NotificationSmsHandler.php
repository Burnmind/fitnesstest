<?php


namespace App\MessageHandler;


use App\Entity\GroupFitnessClasses;
use App\Entity\User;
use App\Message\NotificationSms;
use App\Repository\GroupFitnessClassesRepository;
use App\Repository\UserRepository;
use Exception;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class NotificationSmsHandler extends AbstractNotificationHandler
{
    private HttpClientInterface $client;

    public function __construct(UserRepository $userRepository, GroupFitnessClassesRepository $groupFitnessClassesRepository,
                                HttpClientInterface $client)
    {
        $this->client = $client;

        parent::__construct($userRepository, $groupFitnessClassesRepository);
    }


    public function __invoke(NotificationSms $message)
    {
        $this->startHandling($message);
    }

    /**
     * @param User $user
     * @param GroupFitnessClasses $groupFitnessClass
     * @param string $textMessage
     *
     * @throws TransportExceptionInterface
     * @throws Exception
     */
    public function send(User $user, GroupFitnessClasses $groupFitnessClass, string $textMessage)
    {
        $textMessage = 'Занятие: ' . $groupFitnessClass->getName() . '\n' . $textMessage;

        // Случайно выбираем статус ответа
        $requestCodeList = [
            '200',
            '500'
        ];
        $codeId = array_rand($requestCodeList);

        // Запрос к сервису возвращающему нужный статус
        $response = $this->client->request('GET', 'https://httpstat.us/' . $requestCodeList[$codeId] . '/', [
            'query' => [
                'phone' => $user->getPhone(),
                'message' => $textMessage
            ]
        ]);

        // Если ответ не 200 киаем исключение для повторной отправки
        if ($response->getStatusCode() != 200) {
            throw new Exception();
        }
    }
}

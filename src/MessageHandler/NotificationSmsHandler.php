<?php


namespace App\MessageHandler;


use App\Entity\GroupFitnessClasses;
use App\Entity\User;
use App\Repository\GroupFitnessClassesRepository;
use App\Repository\UserRepository;
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

    /**
     * @param User $user
     * @param GroupFitnessClasses $groupFitnessClass
     * @param string $textMessage
     *
     * @throws TransportExceptionInterface
     */
    public function send(User $user, GroupFitnessClasses $groupFitnessClass, string $textMessage)
    {
        $textMessage = 'Занятие: ' . $groupFitnessClass->getName() . '\n' . $textMessage;

        $response = $this->client->request('GET', 'https://httpstat.us/500/', [
            'query' => [
                'phone' => $user->getPhone(),
                'message' => $textMessage
            ]
        ]);

        if ($response->getStatusCode() != 200) {
            throw new \Exception();
        }
    }
}

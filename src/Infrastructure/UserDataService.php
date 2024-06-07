<?php

namespace AKornienko\Php2024\Infrastructure;

use AKornienko\Php2024\Application\HandleUserData\UserDataRepository;
use AKornienko\Php2024\Domain\AsyncEventMessage\AsyncEventMessage;
use AKornienko\Php2024\Domain\UserDataRequest\UserDataRequest;

class UserDataService implements UserDataRepository
{
    const HANDLE_USER_DATA_MSG = "you request has been proceeded";
    private RabbitClient $client;

    public function __construct(RabbitClient $rabbitClient)
    {
        $this->client = $rabbitClient;
    }

    public function handleUserData(UserDataRequest $request): string
    {
        $msg = new AsyncEventMessage($request);
        $this->client->sendMessage($msg->getValue());
        return self::HANDLE_USER_DATA_MSG;
    }
}

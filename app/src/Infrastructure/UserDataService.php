<?php

namespace AnatolyShilyaev\App\Infrastructure;

use AnatolyShilyaev\App\Application\HandleUserData\UserDataRepository;
use AnatolyShilyaev\App\Domain\Message\Message;
use AnatolyShilyaev\App\Domain\Request\Request;

class UserDataService implements UserDataRepository
{
    const HANDLE_USER_DATA_MSG = "Запрос обработан";
    private RabbitClient $client;

    public function __construct(RabbitClient $rabbitClient)
    {
        $this->client = $rabbitClient;
    }

    public function handleUserData(Request $request): string
    {
        $msg = new Message($request);
        $this->client->sendMessage($msg->getValue());
        return self::HANDLE_USER_DATA_MSG;
    }
}

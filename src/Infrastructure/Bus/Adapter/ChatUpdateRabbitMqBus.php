<?php

namespace App\Infrastructure\Bus\Adapter;

use App\Domain\Bus\ChatUpdateBusInterface;
use App\Domain\DTO\Bus\ChatUpdateDTO;
use App\Infrastructure\Bus\AmqpExchangeEnum;
use App\Infrastructure\Bus\RabbitMqBus;

class ChatUpdateRabbitMqBus implements ChatUpdateBusInterface
{
    public function __construct(private readonly RabbitMqBus $rabbitMqBus)
    {
    }

    public function handleChatUpdate(ChatUpdateDTO $chatUpdateDTO): bool
    {
        return $this->rabbitMqBus->publishToExchange(AmqpExchangeEnum::ChatUpdate, $chatUpdateDTO);
    }
}

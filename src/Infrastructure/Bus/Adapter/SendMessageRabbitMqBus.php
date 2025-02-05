<?php

namespace App\Infrastructure\Bus\Adapter;

use App\Domain\Bus\SendMessageBusInterface;
use App\Domain\DTO\Bus\SendMessageDTO;
use App\Infrastructure\Bus\AmqpExchangeEnum;
use App\Infrastructure\Bus\RabbitMqBus;

class SendMessageRabbitMqBus implements SendMessageBusInterface
{
    public function __construct(private readonly RabbitMqBus $rabbitMqBus)
    {
    }

    public function sendMessage(SendMessageDTO $sendMessageDTO): bool
    {
        return $this->rabbitMqBus->publishToExchange(AmqpExchangeEnum::SendMessage, $sendMessageDTO);
    }
}

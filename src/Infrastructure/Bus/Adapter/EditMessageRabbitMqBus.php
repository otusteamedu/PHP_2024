<?php

namespace App\Infrastructure\Bus\Adapter;

use App\Domain\Bus\EditMessageBusInterface;
use App\Domain\DTO\Bus\EditMessageDTO;
use App\Infrastructure\Bus\AmqpExchangeEnum;
use App\Infrastructure\Bus\RabbitMqBus;

class EditMessageRabbitMqBus implements EditMessageBusInterface
{
    public function __construct(private readonly RabbitMqBus $rabbitMqBus)
    {
    }

    public function editMessage(EditMessageDTO $editMessageDTO): bool
    {
        return $this->rabbitMqBus->publishToExchange(AmqpExchangeEnum::EditMessage, $editMessageDTO);
    }
}

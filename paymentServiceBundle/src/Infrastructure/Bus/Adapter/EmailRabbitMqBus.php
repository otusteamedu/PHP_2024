<?php

namespace PaymentServiceBundle\Infrastructure\Bus\Adapter;

use PaymentServiceBundle\Domain\Bus\EmailRabbitMqBusInterface;
use PaymentServiceBundle\Domain\DTO\Bus\EmailDTO;
use PaymentServiceBundle\Infrastructure\Bus\AmqpExchangeEnum;
use PaymentServiceBundle\Infrastructure\Bus\RabbitMqBus;

class EmailRabbitMqBus implements EmailRabbitMqBusInterface
{
    public function __construct(private readonly RabbitMqBus $rabbitMqBus)
    {
    }

    public function sendEmailMessage(EmailDTO $emailSendDTO): bool
    {
        return $this->rabbitMqBus->publishToExchange(AmqpExchangeEnum::SendEmail, $emailSendDTO);
    }
}

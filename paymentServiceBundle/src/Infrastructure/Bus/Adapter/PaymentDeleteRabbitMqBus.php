<?php

namespace PaymentServiceBundle\Infrastructure\Bus\Adapter;

use PaymentServiceBundle\Domain\Bus\PaymentDeleteBusInterface;
use PaymentServiceBundle\Domain\DTO\Bus\PaymentDeleteDTO;
use PaymentServiceBundle\Infrastructure\Bus\AmqpExchangeEnum;
use PaymentServiceBundle\Infrastructure\Bus\RabbitMqBus;

class PaymentDeleteRabbitMqBus implements PaymentDeleteBusInterface
{
    public function __construct(private readonly RabbitMqBus $rabbitMqBus)
    {
    }

    public function sendPaymentDeleteMessage(PaymentDeleteDTO $paymentDeleteDTO): bool
    {
        return $this->rabbitMqBus->publishToExchange(AmqpExchangeEnum::PaymentDelete, $paymentDeleteDTO);
    }
}

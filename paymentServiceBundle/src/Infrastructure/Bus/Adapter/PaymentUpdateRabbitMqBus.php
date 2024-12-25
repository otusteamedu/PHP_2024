<?php

namespace PaymentServiceBundle\Infrastructure\Bus\Adapter;

use PaymentServiceBundle\Domain\Bus\PaymentUpdateBusInterface;
use PaymentServiceBundle\Domain\DTO\Bus\PaymentUpdateDTO;
use PaymentServiceBundle\Infrastructure\Bus\AmqpExchangeEnum;
use PaymentServiceBundle\Infrastructure\Bus\RabbitMqBus;

class PaymentUpdateRabbitMqBus implements PaymentUpdateBusInterface
{
    public function __construct(private readonly RabbitMqBus $rabbitMqBus)
    {
    }

    public function sendPaymentUpdateMessage(PaymentUpdateDTO $paymentUpdateDTO): bool
    {
        return $this->rabbitMqBus->publishToExchange(AmqpExchangeEnum::PaymentUpdate, $paymentUpdateDTO);
    }
}

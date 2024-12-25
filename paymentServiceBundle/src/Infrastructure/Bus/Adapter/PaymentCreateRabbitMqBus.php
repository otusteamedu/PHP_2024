<?php

namespace PaymentServiceBundle\Infrastructure\Bus\Adapter;

use PaymentServiceBundle\Domain\Bus\PaymentCreateBusInterface;
use PaymentServiceBundle\Domain\DTO\Bus\PaymentCreateDTO;
use PaymentServiceBundle\Infrastructure\Bus\AmqpExchangeEnum;
use PaymentServiceBundle\Infrastructure\Bus\RabbitMqBus;

class PaymentCreateRabbitMqBus implements PaymentCreateBusInterface
{
    public function __construct(private readonly RabbitMqBus $rabbitMqBus)
    {
    }

    public function sendPaymentCreateMessage(PaymentCreateDTO $paymentCreateDTO): bool
    {
        return $this->rabbitMqBus->publishToExchange(AmqpExchangeEnum::PaymentCreate, $paymentCreateDTO);
    }
}

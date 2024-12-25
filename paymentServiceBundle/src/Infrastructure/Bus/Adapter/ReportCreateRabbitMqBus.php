<?php

namespace PaymentServiceBundle\Infrastructure\Bus\Adapter;

use PaymentServiceBundle\Infrastructure\Bus\AmqpExchangeEnum;
use PaymentServiceBundle\Infrastructure\Bus\RabbitMqBus;
use PaymentServiceBundle\Domain\Bus\ReportCreateBusInterface;
use PaymentServiceBundle\Domain\DTO\Bus\ReportCreateDTO;

class ReportCreateRabbitMqBus implements ReportCreateBusInterface
{
    public function __construct(private readonly RabbitMqBus $rabbitMqBus)
    {
    }

    public function sendReportCreateMessage(ReportCreateDTO $reportCreateDTO): bool
    {
        return $this->rabbitMqBus->publishToExchange(AmqpExchangeEnum::ReportCreate, $reportCreateDTO);
    }
}

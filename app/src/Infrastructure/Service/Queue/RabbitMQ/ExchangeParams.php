<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\Queue\RabbitMQ;

use PhpAmqpLib\Exchange\AMQPExchangeType;

class ExchangeParams
{
    public function __construct(
        private string $name,
        private string $type = AMQPExchangeType::FANOUT,
        private bool $durable = true,
        private bool $autoDelete = true
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function isDurable(): bool
    {
        return $this->durable;
    }

    public function isAutoDelete(): bool
    {
        return $this->autoDelete;
    }
}

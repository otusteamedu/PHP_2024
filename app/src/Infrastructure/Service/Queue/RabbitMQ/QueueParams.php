<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\Queue\RabbitMQ;

class QueueParams
{
    public function __construct(
        private string $name,
        private bool $durable = true,
        private bool $autoDelete = true
    ) {
    }

    public function getName(): string
    {
        return $this->name;
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

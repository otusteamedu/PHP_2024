<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\Queue\RabbitMQ;

class BindingParams
{
    public function __construct(private string $routingKey = '')
    {
    }

    public function getRoutingKey(): string
    {
        return $this->routingKey;
    }
}

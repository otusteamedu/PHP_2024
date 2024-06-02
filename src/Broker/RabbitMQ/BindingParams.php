<?php

declare(strict_types=1);

namespace AlexanderGladkov\Broker\RabbitMQ;

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

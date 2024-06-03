<?php

declare(strict_types=1);

namespace AlexanderGladkov\Broker\Config;

use PhpAmqpLib\Exchange\AMQPExchangeType;

class Config
{
    public function getRabbitMQHost(): string
    {
        return getenv('RABBITMQ_HOST');
    }

    public function getRabbitMQPort(): int
    {
        return (int)getenv('RABBITMQ_PORT');
    }

    public function getRabbitMQUser(): string
    {
        return getenv('RABBITMQ_USER');
    }

    public function getRabbitMQPassword(): string
    {
        return getenv('RABBITMQ_PASSWORD');
    }

    public function getExchangeName(): string
    {
        return 'Main';
    }

    public function getExchangeType(): string
    {
        return AMQPExchangeType::FANOUT;
    }

    public function getGMailTransportDsn(): string
    {
        return getenv('GMAIL_TRANSPORT_DSN');
    }
}

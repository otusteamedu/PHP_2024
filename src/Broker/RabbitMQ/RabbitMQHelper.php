<?php

declare(strict_types=1);

namespace AlexanderGladkov\Broker\RabbitMQ;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitMQHelper
{
    public function getConnection(ConnectionSettings $connectionSettings): AMQPStreamConnection
    {
        return new AMQPStreamConnection(
            host: $connectionSettings->getHost(),
            port: $connectionSettings->getPort(),
            user: $connectionSettings->getUsername(),
            password: $connectionSettings->getPassword()
        );
    }

    public function initExchange(AMQPChannel $channel, ExchangeParams $exchangeParams): void
    {
        $channel->exchange_declare(
            exchange: $exchangeParams->getName(),
            type: $exchangeParams->getType(),
            durable: $exchangeParams->isDurable(),
            auto_delete: $exchangeParams->isAutoDelete()
        );
    }

    public function initQueue(
        AMQPChannel $channel,
        ExchangeParams $exchangeParams,
        QueueParams $queueParams,
        ?BindingParams $bindingParams
    ): void {
        $channel->queue_declare(
            queue: $queueParams->getName(),
            durable: $queueParams->isDurable(),
            auto_delete: $queueParams->isAutoDelete()
        );

        if ($bindingParams !== null) {
            $routingKey = $bindingParams->getRoutingKey();
        } else {
            $routingKey = '';
        }

        $channel->queue_bind(
            queue: $queueParams->getName(),
            exchange: $exchangeParams->getName(),
            routing_key: $routingKey
        );
    }
}

<?php

declare(strict_types=1);

namespace App\Banking\Queue;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AbstractConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;

final readonly class ConnectionProvider
{
    public function __construct(
        private AbstractConnection $connection
    ) {}

    public function getConnection(): AbstractConnection
    {
        return $this->connection;
    }

    public function getChannel(): AMQPChannel
    {
        return $this->connection->channel();
    }

    public function setupChannel(AMQPChannel $channel, string $queueName, string $exchangeName): void
    {
        $channel->queue_declare(
            queue: $queueName,
            durable: true,
            auto_delete: false
        );

        $channel->exchange_declare(
            exchange: $exchangeName,
            type: AMQPExchangeType::DIRECT,
            durable: true,
            auto_delete: false
        );

        $channel->queue_bind($queueName, $exchangeName);
    }

    public function closeConnection(): void
    {
        $this->getChannel()->close();
        $this->getConnection()->close();
    }

    public function __destruct()
    {
        $this->closeConnection();
    }
}

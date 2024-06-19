<?php

declare(strict_types=1);

namespace Pozys\BankStatement\Infrastructure\Async\RabbitMQ;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Pozys\BankStatement\Application\UseCase\MessageProcessable;

abstract class Subscriber
{
    protected AMQPStreamConnection $connection;

    public function __construct(ConnectionManager $connectionManager, protected MessageProcessable $handler)
    {
        $this->connection = $connectionManager->getConnection();
    }

    abstract static protected function getQueueName(): string;

    abstract public function processMessage(AMQPMessage $message): void;

    abstract protected function bindQueue(AMQPChannel $channel): AMQPChannel;

    public function handle(): void
    {
        $consumerTag = 'consumer' . getmypid();

        $channel = $this->connection->channel();
        $channel = $this->bindQueue($channel);

        $channel->basic_consume(
            static::getQueueName(),
            $consumerTag,
            false,
            false,
            false,
            false,
            [$this, 'processMessage']
        );

        while ($channel->is_open()) {
            echo 'Waiting for messages. To exit press CTRL+C' . PHP_EOL;
            $channel->wait();
        }

        $channel->close();
        $this->connection->close();
    }
}

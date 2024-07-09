<?php

declare(strict_types=1);

namespace App\Infrastructure\Async\RabbitMQ;

use App\Application\UseCase\MessageProcessable;
use App\Infrastructure\Async\RabbitMQ\ConnectionManager;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Log\LoggerInterface;

abstract class Subscriber
{
    protected AMQPStreamConnection $connection;

    public function __construct(
        ConnectionManager $connectionManager,
        protected MessageProcessable $handler,
        protected LoggerInterface $logger
    ) {
        $this->connection = $connectionManager->getConnection();
    }

    abstract protected static function getQueueName(): string;

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

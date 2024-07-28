<?php

declare(strict_types=1);

namespace App\Queue;

use App\Queue\Message\AbstractQueueMessage;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Queue implements QueueInterface
{
    private AMQPStreamConnection $connection;

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        $this->connection = new AMQPStreamConnection(
            $_ENV['RABBITMQ_HOST'],
            $_ENV['RABBITMQ_PORT'],
            $_ENV['RABBITMQ_USER'],
            $_ENV['RABBITMQ_PASSWORD']
        );
    }

    public function push(AbstractQueueMessage $message): void
    {
        $channel = $this->connection->channel();
        $channel->queue_declare(
            $message::QUEUE_NAME,
            false,
            true,
            false,
            false
        );
        $amqMessage = new AMQPMessage(json_encode($message));
        $channel->basic_publish($amqMessage, '', $message::QUEUE_NAME);
        $channel->close();
    }

    public function pull(string $queueName, callable $callback): void
    {
        $channel = $this->connection->channel();
        $channel->queue_declare($queueName, false, true, false, false);
        $channel->basic_consume(
            $queueName,
            '',
            false,
            false,
            false,
            false,
            $callback)
        ;

        try {
            $channel->consume();
        } catch (\Throwable $exception) {
            throw $exception;
        } finally {
            $channel->close();
        }
    }

    public function getMessages(string $queueName): \Iterator
    {
        $channel = $this->connection->channel();
        $channel->queue_declare($queueName, false, true, false, false);

        while ($msg = $channel->basic_get($queueName)) {
            yield json_decode($msg->getBody(), true);
        }

        $channel->close();
    }

    /**
     * @throws \Exception
     */
    public function __destruct()
    {
        $this->connection->close();
    }
}

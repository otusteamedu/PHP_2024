<?php

declare(strict_types=1);

namespace Alogachev\Homework\Infrastructure\Messaging\RabbitMQ;

use Alogachev\Homework\Application\Messaging\QueueMessageInterface;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class GenerateBankStatementProducer
{
    private const QUEUE_NAME = 'GenerateBankStatement';

    private AMQPStreamConnection $connection;
    private AMQPChannel $channel;

    public function __construct(
        string $rabbitHost,
        int $rabbitPort,
        string $rabbitUser,
        string $rabbitPassword,
    ) {
        $this->connection = new AMQPStreamConnection($rabbitHost, $rabbitPort, $rabbitUser, $rabbitPassword);
        $this->channel = $this->connection->channel();
        $this->channel->queue_declare(
            self::QUEUE_NAME,
            false,
            true,
            false,
            false
        );
    }

    public function sendMessage(QueueMessageInterface $message): void
    {

    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}

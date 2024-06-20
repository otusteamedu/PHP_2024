<?php

declare(strict_types=1);

namespace Alogachev\Homework\Infrastructure\Messaging\RabbitMQ\Producer;

use Alogachev\Homework\Application\Messaging\Message\QueueMessageInterface;
use Alogachev\Homework\Application\Messaging\Producer\ProducerInterface;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class GenerateBankStatementProducer implements ProducerInterface
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
        $message = new AMQPMessage(json_encode($message->toArray()));
        $this->channel->basic_publish($message, '', self::QUEUE_NAME);
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}

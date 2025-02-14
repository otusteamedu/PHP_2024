<?php

declare(strict_types=1);

namespace App\Infrastructure\Messaging;

use App\Application\Messaging\MessageSenderInterface;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMqMessageSender implements MessageSenderInterface
{
    private AMQPStreamConnection $connection;

    public function __construct(
        string $host,
        int    $port,
        string $user,
        string $password
    )
    {
        $this->connection = new AMQPStreamConnection($host, $port, $user, $password);
    }

    public function send(string $queue, array $message, string $exchange, string $routingKey): void
    {
        $channel = $this->connection->channel();
        $channel->queue_declare($queue, false, true, false, false);

        $msg = new AMQPMessage(
            json_encode($message),
            ['content_type' => 'application/json']
        );

        $channel->basic_publish($msg, $exchange, $routingKey);

        $channel->close();
        $this->connection->close();
    }
}

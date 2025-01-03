<?php

namespace VladimirGrinko\Rabbit\App\Queue;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQService implements QueueInterface
{
    private AMQPStreamConnection $connection;
    private string $queueName;

    public function __construct(string $host, int $port, string $user, string $password, string $queueName)
    {
        $this->connection = new AMQPStreamConnection($host, $port, $user, $password);
        $this->queueName = $queueName;
    }

    public function sendMessage(array $data): void
    {
        $channel = $this->connection->channel();
        $channel->queue_declare(queue: $this->queueName, durable: true, auto_delete: false);

        $message = new AMQPMessage(json_encode($data), ['delivery_mode' => 2]);
        $channel->basic_publish(msg: $message, routing_key: $this->queueName);

        $channel->close();
    }

    public function consumeMessages(callable $callback): void
    {
        $channel = $this->connection->channel();
        $channel->queue_declare(queue: $this->queueName, durable: true, auto_delete: false);

        $channel->basic_qos(null, 1, null);
        $channel->basic_consume(queue: $this->queueName, callback: function ($msg) use ($callback) {
            $data = json_decode($msg->body, true);
            $callback($data);
            $msg->ack();
        });

        while ($channel->is_consuming()) {
            $channel->wait();
        }

        $channel->close();
    }

    public function __destruct()
    {
        $this->connection->close();
    }
}

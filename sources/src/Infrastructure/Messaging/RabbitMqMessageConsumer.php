<?php

declare(strict_types=1);

namespace App\Infrastructure\Messaging;

use App\Application\Messaging\TaskCreatedHandler;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMqMessageConsumer
{
    private AMQPStreamConnection $connection;
    private string $queue;
    private array $handlers;

    public function __construct(
        string $host,
        int    $port,
        string $user,
        string $password,
        string $queue
    )
    {
        $this->connection = new AMQPStreamConnection($host, $port, $user, $password);
        $this->queue = $queue;

        $this->handlers = [
            'task.created' => new TaskCreatedHandler(),
        ];
    }

    public function consume(): void
    {
        $channel = $this->connection->channel();
        $channel->queue_declare($this->queue, false, true, false, false);

        $callback = function (AMQPMessage $msg) {

            $message = json_decode($msg->body, true);

            if (!isset($message['action'])) {
                return;
            }

            $action = $message['action'];

            if (isset($this->handlers[$action])) {
                $this->handlers[$action]->handle($message);
            }
        };

        $channel->basic_consume(
            $this->queue,
            '',
            false,
            true,
            false,
            false,
            $callback
        );

        while ($channel->is_consuming()) {
            $channel->wait();
        }
    }
}

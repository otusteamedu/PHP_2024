<?php

declare(strict_types=1);

namespace App\Infrastructure\Drivers\Queues;

use App\Application\Contracts\QueueDriverInterface;
use App\Infrastructure\AmqpClient;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;

readonly class AmqpDriver implements QueueDriverInterface
{
    private AMQPChannel $channel;

    public function __construct(private AmqpClient $connection, private string $queueName = 'default_queue')
    {
        $this->channel = $this->connection->getChannel();
    }

    public function sendMessage(string $message): void
    {
        $this->channel->queue_declare(queue: $this->queueName, durable: true, auto_delete: false);
        $msg = new AMQPMessage($message);
        $this->channel->basic_publish($msg, '', $this->queueName);
    }

    /**
     * @throws \ErrorException
     */
    public function receiveMessage(callable $callback): void
    {
        $this->channel->queue_declare(queue: $this->queueName, durable: true, auto_delete: false);
        $this->channel->basic_consume(queue: $this->queueName, callback: $callback);

        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }
    }

    /**
     * @throws \Exception
     */
    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}

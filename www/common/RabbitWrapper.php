<?php

declare(strict_types=1);

namespace Common;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitWrapper
{
    private string $queue;

    private AMQPStreamConnection $connection;

    public function __construct(string $queueName, AMQPStreamConnection $connection)
    {
        $this->queue = $queueName;
        $this->connection = $connection;
    }

    private function getChannel(): AMQPChannel
    {
        return $this->connection->channel();
    }

    private function initQueue()
    {
        $this->getChannel()->queue_declare($this->queue, false, false, false, false);
    }

    public function sendMessage(MessageDTO $message)
    {
        $this->initQueue();
        $msg = new AMQPMessage($message);
        $this->getChannel()->basic_publish($msg, '', $this->queue);
    }

    public function getMessageOrNull(): ?MessageDTO
    {
        $this->initQueue();
        $message = $this->getChannel()->basic_get($this->queue, true, null);
        if ($message) {
            return MessageDTO::buildFromJSONString($message->body);
        }
        return null;
    }
}

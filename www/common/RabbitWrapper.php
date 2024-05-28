<?php

declare(strict_types=1);

namespace Common;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitWrapper
{
    private string $username;
    private string $password;
    private string $host;
    private int $port;
    private string $queue;

    private AMQPStreamConnection $connection;

    public function __construct()
    {
        $this->username = getenv('RABBITMQ_USER');
        $this->password = getenv('RABBITMQ_PASS');
        $this->host = getenv('RABBITMQ_HOST');
        $this->queue = getenv('RABBITMQ_QUEUE');
        $this->port = (int) getenv('RABBITMQ_PORT');
        $this->connection = new AMQPStreamConnection($this->host, $this->port, $this->username, $this->password);
    }

    public function getChannel(): AMQPChannel
    {
        return $this->connection->channel();
    }

    public function initQueue()
    {
        $this->getChannel()->queue_declare($this->queue, false, false, false, false);
    }

    public function sendMessage(MessageDTO $message)
    {
        $msg = new AMQPMessage($message);
        $this->getChannel()->basic_publish($msg, '', $this->queue);
    }

    public function getMessageOrNull(): ?MessageDTO
    {
        $message = $this->getChannel()->basic_get($this->queue, true, null);
        if ($message)
            return MessageDTO::buildFromJSONString($message->body);
        return null;
    }
}
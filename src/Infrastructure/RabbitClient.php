<?php

namespace SergeyShirykalov\HomeworkRabbit\Infrastructure;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Channel\AMQPChannel;

class RabbitClient
{
    private string $queueName;
    private AMQPChannel $channel;

    /**
     * @throws \Exception
     */
    public function __construct(string $queueName)
    {
        $this->queueName = $queueName;
        try {
            $connection = new AMQPStreamConnection(
                $_ENV["RABBIT_HOST"],
                $_ENV["RABBIT_PORT"],
                $_ENV["RABBIT_USER"],
                $_ENV["RABBIT_PASSWORD"],
            );
            $this->channel = $connection->channel();

            $this->channel->queue_declare($queueName, false, false, false, false);
        } catch (\Exception $exception) {
            throw new \Exception("Error connection to rabbit" . $exception->getMessage());
        }
    }

    public function sendMessage($msg): void
    {
        $msg = new AMQPMessage($msg);
        $this->channel->basic_publish($msg, '', $this->queueName);
    }

    /**
     * @throws \ErrorException
     */
    public function consume(callable $callback): void
    {
        $this->channel->basic_consume($this->queueName, '', false, true, false, false, $callback);
        $this->channel->consume();
    }
}
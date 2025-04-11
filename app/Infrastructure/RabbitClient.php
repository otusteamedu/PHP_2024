<?php

namespace App\Infrastructure;

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
    public function __construct()
    {
        $this->queueName = config("rabbit.queue_name");
        try {
            $connection = new AMQPStreamConnection(
                config("rabbit.host"),
                config("rabbit.port"),
                config("rabbit.user"),
                config("rabbit.password")
            );
            $this->channel = $connection->channel();

            $this->channel->queue_declare($this->queueName, false, false, false, false);
        } catch (\Exception $exception) {
            throw new \Exception("Error connection to rabbit: " . $exception->getMessage());
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

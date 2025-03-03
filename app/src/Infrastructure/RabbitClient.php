<?php

namespace AnatolyShilyaev\App\Infrastructure;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitClient
{
    private string $queueName;
    private AMQPChannel $channel;

    /**
     * @throws \Exception
     */
    public function __construct(Config $config, string $queueName)
    {
        $this->queueName = $queueName;
        try {
            $connection = new AMQPStreamConnection(
                $config->host,
                $config->port,
                $config->user,
                $config->password
            );
            $this->channel = $connection->channel();

            $this->channel->queue_declare($queueName, false, false, false, false);
        } catch (\Exception $exception) {
            throw new \Exception("Can't connect rabbit" . $exception->getMessage());
        }
    }

    public function sendMessage(AMQPMessage $msg): void
    {
        $this->channel->basic_publish($msg, '', $this->queueName);
    }

    /**
     * @throws \ErrorException
     */
    public function listenQueue(callable $callback): void
    {
        $this->channel->basic_consume($this->queueName, '', false, true, false, false, $callback);
        $this->channel->consume();
    }
}

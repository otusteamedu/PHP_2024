<?php

namespace App\Infrastructure;

use Exception;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitClient
{
    private string $queueName;
    private $channel;

    /**
     * @throws \Exception
     */
    public function __construct(Config $config, string $queueName)
    {
        $this->queueName = $queueName;
        try {
            $connection = new AMQPStreamConnection(
                $config->rabbitHost,
                $config->rabbitPort,
                $config->rabbitUser,
                $config->rabbitPassword
            );
            $this->channel = $connection->channel();

            $this->channel->queue_declare($queueName, false, false, false, false);
        } catch (\Exception $exception) {
            throw new Exception("can't connect rabbit" . $exception->getMessage());
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

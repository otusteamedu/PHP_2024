<?php

declare(strict_types=1);

namespace App;

use Exception;
use PhpAmqpLib\Channel\AbstractChannel;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

abstract class RabbitMQAbstract
{
    private AbstractChannel|null|AMQPChannel $channel = null;

    public function __construct(private readonly AMQPStreamConnection $connection)
    {
    }

    protected function getChannel(): AMQPChannel|AbstractChannel
    {
        if (empty($this->channel) || null === $this->channel->getChannelId()) {
            $this->channel = $this->connection->channel();
        }

        return $this->channel;
    }

    public function declare(string $queueName): void
    {
        $this->getChannel()->queue_declare($queueName, false, true, false, false);
    }

    /**
     * @throws Exception
     */
    public function __destruct()
    {
        $this->channel?->close();
        $this->connection->close();
    }
}

<?php

declare(strict_types=1);

namespace App\Infrastructure;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class AmqpClient
{
    private AMQPStreamConnection $connection;
    private AMQPChannel $channel;

    public function __construct(array $config)
    {
        $this->connection = new AMQPStreamConnection(
            $config['host'],
            $config['port'],
            $config['user'],
            $config['password'],
        );

        $this->channel = $this->connection->channel();
    }

    public function getChannel(): AMQPChannel
    {
        return $this->channel;
    }

    /**
     * @throws \Exception
     */
    public function close(): void
    {
        $this->channel->close();
        $this->connection->close();
    }
}
<?php

declare(strict_types=1);

namespace Orlov\Otus\Connection;

use Exception;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Channel\AbstractChannel;

class RabbitMqConnect implements ConnectionInterface
{
    private AMQPStreamConnection $connect;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->connect = new AMQPStreamConnection(
            $_ENV['BROKER_HOST'],
            $_ENV['BROKER_PORT'],
            $_ENV['BROKER_USER'],
            $_ENV['BROKER_PASSWORD']
        );
    }
    public function getClient(): AMQPChannel|AbstractChannel
    {
        return $this->connect->channel();
    }

    /**
     * @throws Exception
     */
    public function close(): void
    {
        $this->connect->close();
    }
}

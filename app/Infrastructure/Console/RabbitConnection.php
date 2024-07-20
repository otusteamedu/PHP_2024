<?php

declare(strict_types=1);

namespace App\Infrastructure\Console;

use Exception;
use PhpAmqpLib\Channel\AbstractChannel;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

final class RabbitConnection
{
    private AMQPStreamConnection $connection;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->connection = new AMQPStreamConnection(
            env('RABBIT_HOST'),
            env('RABBIT_PORT'),
            env('RABBIT_USERNAME'),
            env('RABBIT_PASSWORD')
        );
    }

    public function channel(): AMQPChannel
    {
        return $this->connection->channel();
    }
}
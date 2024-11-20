<?php

declare(strict_types=1);

namespace App;

use PhpAmqpLib\Connection\AMQPStreamConnection;

class ConnectionCreator
{
    public static function create(): AMQPStreamConnection
    {
        $host = getenv('RABBITMQ_HOST');
        $port = (int)getenv('RABBITMQ_PORT');
        $user = getenv('RABBITMQ_USER');
        $password = getenv('RABBITMQ_PASSWORD');

        return new AMQPStreamConnection($host, $port, $user, $password);
    }
}

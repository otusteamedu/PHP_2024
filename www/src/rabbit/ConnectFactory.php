<?php

namespace Ahor\Hw19\rabbit;

use PhpAmqpLib\Connection\AMQPStreamConnection;

class ConnectFactory
{
    public static function create(Config $config): AMQPStreamConnection
    {
        return new AMQPStreamConnection($config->host, $config->port, $config->user, $config->password);
    }
}

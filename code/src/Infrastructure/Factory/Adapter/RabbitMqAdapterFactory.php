<?php

declare(strict_types=1);

namespace Viking311\Api\Infrastructure\Factory\Adapter;

use Exception;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Viking311\Api\Infrastructure\Adapter\RabbitMqAdapter;
use Viking311\Api\Infrastructure\Config\Config;

class RabbitMqAdapterFactory
{
    /**
     * @return RabbitMqAdapter
     * @throws Exception
     */
    public static function createInstance(): RabbitMqAdapter
    {
        $config = new Config();

        $connection = new AMQPStreamConnection(
            $config->rabbitMq->host,
            $config->rabbitMq->port,
            $config->rabbitMq->user,
            $config->rabbitMq->password
        );

        return new RabbitMqAdapter(
            $connection,
            $config->rabbitMq->queue
        );
    }
}

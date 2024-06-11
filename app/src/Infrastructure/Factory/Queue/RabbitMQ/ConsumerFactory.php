<?php

namespace App\Infrastructure\Factory\Queue\RabbitMQ;

use App\Infrastructure\Service\Queue\RabbitMQ\ConnectionSettings;
use App\Infrastructure\Service\Queue\RabbitMQ\ExchangeParams;
use App\Infrastructure\Service\Queue\RabbitMQ\QueueParams;
use App\Infrastructure\Service\Queue\RabbitMQ\RabbitMQConsumer;

class ConsumerFactory
{
    public function create(
        ConnectionSettings $connectionSettings,
        ExchangeParams $exchangeParams
    ): RabbitMQConsumer {
        $queueParams = new QueueParams('Main');
        return new RabbitMQConsumer($connectionSettings, $exchangeParams, $queueParams);
    }
}

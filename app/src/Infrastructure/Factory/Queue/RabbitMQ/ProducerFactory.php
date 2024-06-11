<?php

namespace App\Infrastructure\Factory\Queue\RabbitMQ;

use App\Infrastructure\Service\Queue\RabbitMQ\ConnectionSettings;
use App\Infrastructure\Service\Queue\RabbitMQ\ExchangeParams;
use App\Infrastructure\Service\Queue\RabbitMQ\RabbitMQProducer;

class ProducerFactory
{
    public function create(
        ConnectionSettings $connectionSettings,
        ExchangeParams $exchangeParams,
    ): RabbitMQProducer {
        return new RabbitMQProducer($connectionSettings, $exchangeParams);
    }
}

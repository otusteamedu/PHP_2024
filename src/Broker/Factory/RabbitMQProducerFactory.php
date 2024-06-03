<?php

namespace AlexanderGladkov\Broker\Factory;

use AlexanderGladkov\Broker\Config\Config;
use AlexanderGladkov\Broker\RabbitMQ\ConnectionSettings;
use AlexanderGladkov\Broker\RabbitMQ\ExchangeParams;
use AlexanderGladkov\Broker\RabbitMQ\RabbitMQProducer;
use AlexanderGladkov\Broker\Exchange\ProducerInterface;

class RabbitMQProducerFactory
{
    public function create(Config $config): ProducerInterface
    {
        $connectionSettings = new ConnectionSettings(
            $config->getRabbitMQHost(),
            $config->getRabbitMQPort(),
            $config->getRabbitMQUser(),
            $config->getRabbitMQPassword()
        );

        $exchangeParams = new ExchangeParams($config->getExchangeName(), $config->getExchangeType());
        return new RabbitMQProducer($connectionSettings, $exchangeParams);
    }
}

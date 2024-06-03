<?php

namespace AlexanderGladkov\Broker\Factory;

use AlexanderGladkov\Broker\Config\Config;
use AlexanderGladkov\Broker\Exchange\ConsumerInterface;
use AlexanderGladkov\Broker\RabbitMQ\ConnectionSettings;
use AlexanderGladkov\Broker\RabbitMQ\ExchangeParams;
use AlexanderGladkov\Broker\RabbitMQ\QueueParams;
use AlexanderGladkov\Broker\RabbitMQ\RabbitMQConsumer;

class RabbitMQConsumerFactory
{
    public function create(Config $config): ConsumerInterface
    {
        $connectionSettings = new ConnectionSettings(
            $config->getRabbitMQHost(),
            $config->getRabbitMQPort(),
            $config->getRabbitMQUser(),
            $config->getRabbitMQPassword()
        );

        $exchangeParams = new ExchangeParams($config->getExchangeName(), $config->getExchangeType());
        $queueParams = new QueueParams('Main');
        return new RabbitMQConsumer($connectionSettings, $exchangeParams, $queueParams);
    }
}

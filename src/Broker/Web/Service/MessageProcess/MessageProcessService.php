<?php

declare(strict_types=1);

namespace AlexanderGladkov\Broker\Web\Service\MessageProcess;

use AlexanderGladkov\Broker\Config\Config;
use AlexanderGladkov\Broker\RabbitMQ\ConnectionSettings;
use AlexanderGladkov\Broker\RabbitMQ\ExchangeParams;
use AlexanderGladkov\Broker\RabbitMQ\RabbitMQProducer;

class MessageProcessService
{
    private RabbitMQProducer $producer;

    public function __construct(Config $config)
    {
        $connectionSettings = new ConnectionSettings(
            $config->getRabbitMQHost(),
            $config->getRabbitMQPort(),
            $config->getRabbitMQUser(),
            $config->getRabbitMQPassword()
        );

        $exchangeParams = new ExchangeParams($config->getExchangeName(), $config->getExchangeType());
        $this->producer = new RabbitMQProducer($connectionSettings, $exchangeParams);
    }

    /**
     * @throws ValidationException
     */
    public function process(MessageProcessRequest $request): void
    {
        $errors = $request->validate();
        if (count($errors) > 0) {
            throw new ValidationException($errors);
        }

        $message = json_encode($request->toArray());
        $this->producer->publish($message);
    }
}

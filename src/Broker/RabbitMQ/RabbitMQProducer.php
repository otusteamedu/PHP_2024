<?php

declare(strict_types=1);

namespace AlexanderGladkov\Broker\RabbitMQ;

use AlexanderGladkov\Broker\Exchange\ProducerInterface;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Channel\AMQPChannel;

class RabbitMQProducer implements ProducerInterface
{
    private AMQPStreamConnection $connection;
    private AMQPChannel $channel;
    private string $exchangeName;

    public function __construct(
        ConnectionSettings $connectionSettings,
        ExchangeParams $exchangeParams
    ) {
        $rabbitMQHelper = new RabbitMQHelper();
        $this->connection = $rabbitMQHelper->getConnection($connectionSettings);
        $this->channel = $this->connection->channel();
        $rabbitMQHelper->initExchange($this->channel, $exchangeParams);
        $this->exchangeName = $exchangeParams->getName();
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }

    public function publish(string $message): void
    {
        $this->publishInternal($message);
    }

    private function publishInternal(string $message, string $routingKey = ''): void
    {
        $this->channel->basic_publish(new AMQPMessage($message), $this->exchangeName, $routingKey);
    }
}

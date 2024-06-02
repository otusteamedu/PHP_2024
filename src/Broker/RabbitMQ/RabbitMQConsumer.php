<?php

declare(strict_types=1);

namespace AlexanderGladkov\Broker\RabbitMQ;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Channel\AMQPChannel;
use Closure;

class RabbitMQConsumer
{
    private AMQPStreamConnection $connection;
    private AMQPChannel $channel;
    private string $queueName;

    public function __construct(
        ConnectionSettings $connectionSettings,
        ExchangeParams $exchangeParams,
        QueueParams $queueParams,
        ?BindingParams $bindingParams = null
    ) {
        $rabbitMQHelper = new RabbitMQHelper();
        $this->connection = $rabbitMQHelper->getConnection($connectionSettings);
        $this->channel = $this->connection->channel();
        $rabbitMQHelper->initExchange($this->channel, $exchangeParams);
        $rabbitMQHelper->initQueue($this->channel, $exchangeParams, $queueParams, $bindingParams);
        $this->queueName = $queueParams->getName();
    }

    public function consume(Closure $callback, bool $acknowledgement = true): void
    {
        $this->channel->basic_consume(
            queue: $this->queueName,
            no_ack: !$acknowledgement,
            callback:  $callback
        );

        $this->channel->consume();
    }

    public function stopConsume(): void
    {
        $this->channel->stopConsume();
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}

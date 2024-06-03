<?php

declare(strict_types=1);

namespace AlexanderGladkov\Broker\RabbitMQ;

use AlexanderGladkov\Broker\Exchange\ConsumerInterface;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Channel\AMQPChannel;
use Closure;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQConsumer implements ConsumerInterface
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

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }

    public function consume(Closure $callback): void
    {
        $this->consumeInternal(function (AMQPMessage $ampqMessage) use ($callback) {
            $callback(new RabbitMqMessage($ampqMessage));
        });
    }

    public function consumeInternal(Closure $callback, bool $acknowledgement = true): void
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
}

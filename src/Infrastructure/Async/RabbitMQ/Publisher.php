<?php

declare(strict_types=1);

namespace App\Infrastructure\Async\RabbitMQ;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use App\Application\UseCase\MessageBrokerInterface;

abstract class Publisher implements MessageBrokerInterface
{
    protected AMQPStreamConnection $connection;

    public function __construct(ConnectionManager $connectionManager)
    {
        $this->connection = $connectionManager->getConnection();
    }

    abstract protected function declareExchange(AMQPChannel $channel): AMQPChannel;

    abstract protected static function getExchangeName(): string;

    public function publish(array $data): void
    {
        $channel = $this->connection->channel();
        $channel = $this->declareExchange($channel);

        $message = $this->prepareMessage($data);
        $channel->basic_publish($message, static::getExchangeName());

        $channel->close();
    }

    private function prepareMessage(array $data): AMQPMessage
    {
        return new AMQPMessage(json_encode($data), array('content_type' => 'text/plain'));
    }
}

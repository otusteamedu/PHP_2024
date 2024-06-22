<?php

declare(strict_types=1);

namespace Alogachev\Homework\Infrastructure\Messaging\RabbitMQ;

use Alogachev\Homework\Application\Messaging\DTO\AMQPQueueDto;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitManager implements RabbitManagerInterface
{
    public function __construct(
        private readonly string $rabbitHost,
        private readonly int $rabbitPort,
        private readonly string $rabbitUser,
        private readonly string $rabbitPassword,
    ) {
    }

    public function getRabbitConnection(): AMQPStreamConnection
    {
        return new AMQPStreamConnection(
            $this->rabbitHost,
            $this->rabbitPort,
            $this->rabbitUser,
            $this->rabbitPassword,
        );
    }

    public function getChannel(AMQPStreamConnection $connection): AMQPChannel
    {
        return $connection->channel();
    }

    public function getChannelWithQueueDeclared(AMQPQueueDto $queueDto): AMQPChannel
    {
        $connection = $this->getRabbitConnection();
        $channel = $this->getChannel($connection);

        $channel->queue_declare(
            $queueDto->queueName,
            $queueDto->passive,
            $queueDto->durable,
            $queueDto->exclusive,
            $queueDto->auto_delete
        );

        return $channel;
    }
}

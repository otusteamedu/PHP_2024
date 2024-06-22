<?php

declare(strict_types=1);

namespace Alogachev\Homework\Infrastructure\Messaging\RabbitMQ;

use Alogachev\Homework\Application\Messaging\DTO\AMQPQueueDto;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

interface RabbitManagerInterface
{
    public function getRabbitConnection(): AMQPStreamConnection;
    public function getChannel(AMQPStreamConnection $connection): AMQPChannel;
    public function getChannelWithQueueDeclared(AMQPQueueDto $queueDto): AMQPChannel;
}

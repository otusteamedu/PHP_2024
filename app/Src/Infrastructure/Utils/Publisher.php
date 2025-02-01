<?php
namespace Src\Infrastructure\Utils;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Src\Domain\Interface\PublisherInterface;

class Publisher implements PublisherInterface
{
    private AMQPStreamConnection $connection;

    /**
     * @throws \Exception
     */
    public function sendMessageToChannel(string $queue_name, string $message): void
    {
        $this->connection = new AMQPStreamConnection(
            getenv('RABBIT_HOST'),
            getenv('RABBIT_PORT'),
            getenv('RABBIT_USER'),
            getenv('RABBIT_PASSWORD')
        );

        $channel = $this->connection->channel();

        $channel->queue_declare($queue_name, false, false, false, false);

        $channel->basic_publish(new AMQPMessage($message), '', $queue_name);

        $channel->close();
        $this->connection->close();
    }
}
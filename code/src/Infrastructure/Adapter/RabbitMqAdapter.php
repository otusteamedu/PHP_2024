<?php

declare(strict_types=1);

namespace Viking311\Queue\Infrastructure\Adapter;

use Exception;
use PhpAmqpLib\Channel\AbstractChannel;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Viking311\Queue\Application\Adapter\QueueAdapterInterface;

class RabbitMqAdapter implements QueueAdapterInterface
{
    /** @var AMQPChannel */
    private AbstractChannel $channel;

    /**
     * @param AMQPStreamConnection $connection
     * @param string $queue
     */
    public function __construct(
        private readonly AMQPStreamConnection $connection,
        private readonly string $queue,
    )
    {
        $this->channel = $this->connection->channel();
        $this->channel->queue_declare(
            $this->queue,
            false,
            true,
            false,
            false
        );
    }

    /**
     * @param string $message
     * @return void
     */
    public function send(string $message): void
    {
        $msg = new AMQPMessage(
            $message,
            array('delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT)
        );

        $this->channel->basic_publish(
            $msg,
            '',
            $this->queue
        );
    }

    public function receive(): string
    {
        // TODO: Implement receive() method.
    }

    /**
     * @throws Exception
     */
    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}

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

    private string $lastReceivedMessage;

    /**
     * @param AMQPStreamConnection $connection
     * @param string $queue
     */
    public function __construct(
        private readonly AMQPStreamConnection $connection,
        private readonly string               $queue,
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

    /**
     * @return string
     */
    public function receive(): string
    {
        $this->channel->basic_qos(0, 1, null);
        $this->channel->basic_consume(
            $this->queue,
            '',
            false,
            false,
            false,
            false,
            [$this, 'storeMessage']
        );
        $this->channel->wait();

        return $this->lastReceivedMessage;
    }

    /**
     * @param AMQPMessage $msg
     * @return void
     */
    public function storeMessage(AMQPMessage $msg): void
    {
        $this->lastReceivedMessage = $msg->getBody();
        $msg->getChannel()->basic_ack($msg->getDeliveryTag());
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

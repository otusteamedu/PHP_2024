<?php

declare(strict_types=1);

namespace Orlov\Otus\Producer;

use PhpAmqpLib\Channel\AbstractChannel;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;
use Orlov\Otus\Connection\ConnectionInterface;

class RabbitMqProducer
{
    private AMQPChannel|AbstractChannel $channel;
    private string $exchange;
    private string $queue;

    public function __construct(private ConnectionInterface $connect)
    {
        $this->channel = $this->connect->getClient();
        $this->exchange = $_ENV['EXCHANGE'];
        $this->queue = $_ENV['QUEUE'];
    }

    public function send(string $message): void
    {
        $this->channel->queue_declare($this->queue, false, true, false, false);
        $this->channel->exchange_declare($this->exchange, AMQPExchangeType::DIRECT, false, true, false);
        $this->channel->queue_bind($this->queue, $this->exchange);

        $this->messagePublish($message);

        $this->channel->close();
        $this->connect->close();
    }

    private function messagePublish(string $message): void
    {
        $message = new AMQPMessage($message, [
            'content_type' => 'text/plain',
            'delivery_mode' => AMQPMessage::DELIVERY_MODE_NON_PERSISTENT
        ]);
        $this->channel->basic_publish($message, $this->exchange);
    }
}

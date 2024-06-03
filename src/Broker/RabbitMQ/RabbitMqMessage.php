<?php

namespace AlexanderGladkov\Broker\RabbitMQ;

use AlexanderGladkov\Broker\Exchange\MessageInterface;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMqMessage implements MessageInterface
{
    public function __construct(private AMQPMessage $message)
    {
    }

    public function getContent(): string
    {
        return $this->message->getBody();
    }

    public function ack(): void
    {
        $this->message->ack();
    }

    public function nack(): void
    {
        $this->message->nack(false);
    }
}

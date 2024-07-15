<?php

namespace Ahor\Hw19\rabbit;

use PhpAmqpLib\Message\AMQPMessage;

class Producer extends RabbitMQ
{
    public function publish(array $msgBody, string $queueName): void
    {
        $msg = new AMQPMessage(
            json_encode($msgBody, JSON_THROW_ON_ERROR),
            ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]
        );

        $this->declare($queueName);

        $this->getChannel()->basic_publish($msg, '', $queueName);
    }
}

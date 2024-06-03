<?php

declare(strict_types=1);

namespace App;

use PhpAmqpLib\Message\AMQPMessage;

class Producer extends RabbitMQAbstract
{
    public function publish(array $msgBody, string $queueName): void
    {
        $msg = new AMQPMessage(
            json_encode($msgBody),
            ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]
        );

        $this->declare($queueName);

        $this->getChannel()->basic_publish($msg, '', $queueName);
    }
}

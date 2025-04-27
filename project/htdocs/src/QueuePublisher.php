<?php

namespace Src;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class QueuePublisher
{
    const DELIVERY_MODE_PERSISTENT = 2;

    public static function publish(array $data)
    {
        // Подключаемся к RabbitMQ
        $connection = new AMQPStreamConnection('MyRabbitMQ', 5672, 'admin', 'secret');
        $channel = $connection->channel();
        $channel->queue_declare('task_queue', false, true, false, false);
        $msg = new AMQPMessage(
            json_encode($data),
            ['delivery_mode' => self::DELIVERY_MODE_PERSISTENT]  // Используем явное определение константы
        );
        $channel->basic_publish($msg, '', 'task_queue');
        $channel->close();
        $connection->close();
    }
}
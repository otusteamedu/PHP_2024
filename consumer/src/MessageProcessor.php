<?php

namespace Consumer;

use Exception;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class MessageProcessor
{
    private const QUEUE_NAME = 'otus_queue';

    /**
     * @throws Exception
     */
    public function consume(): void
    {
        $rabbitmqHost = getenv('RABBITMQ_HOST');
        $rabbitmqPort = getenv('RABBITMQ_PORT');
        $rabbitmqUser = getenv('RABBITMQ_USER_NAME');
        $rabbitmqPassword = getenv('RABBITMQ_PASSWORD');
        var_dump($rabbitmqHost, $rabbitmqPassword, $rabbitmqPort, $rabbitmqUser);
        $queueName = self::QUEUE_NAME;

        $connection = new AMQPStreamConnection($rabbitmqHost, $rabbitmqPort, $rabbitmqUser, $rabbitmqPassword);
        $channel = $connection->channel();

        $channel->queue_declare($queueName, false, true, false, false);

        echo 'Waiting for messages. To exit press CTRL+C' . PHP_EOL;

        $callback = static function (AMQPMessage $msg) {
            $data = json_decode($msg->body, true, 512, JSON_THROW_ON_ERROR);
            if (json_last_error() === JSON_ERROR_NONE) {
                echo 'Processing request for email: ' . $data['email'] . PHP_EOL;
            } else {
                echo 'Error decoding JSON: ' . json_last_error_msg() . PHP_EOL;
            }
        };

        $channel->basic_consume($queueName, '', false, true, false, false, $callback);

        while ($channel->is_consuming()) {
            $channel->wait();
        }

        $channel->close();
        $connection->close();
    }
}
<?php

namespace App\Services;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQService
{
    protected $connection;
    protected $channel;

    public function __construct()
    {
        $this->connection = new AMQPStreamConnection('otus-rabbit-mq', 5672, 'user', 'password');
        $this->channel = $this->connection->channel();
        $this->channel->queue_declare('request_queue', false, true, false, false, false, []);
    }

    public function send($data)
    {
        $msg = new AMQPMessage(json_encode($data));
        $this->channel->basic_publish($msg, '', 'request_queue');
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}

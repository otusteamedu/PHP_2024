<?php
declare(strict_types=1);

namespace App\Infrastructure\Services;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class SendRabbitMQ
{
    private string $queue = 'email_queue';

    public function __construct(){
        $config = ROOT .'/config/amqpconfig.php';
        include($config);
    }

    public function execute($messageBody)
    {
        $connection = new AMQPStreamConnection(HOST,PORT,USER,PASS);
        $channel = $connection->channel();

        $channel->queue_declare($this->queue, false, true, false, false);

        $data = new AMQPMessage($messageBody, array('delivery_mode'=>2));
        $channel->basic_publish($data,'', $this->queue);

        $channel->close();
        $connection->close();
    }

}
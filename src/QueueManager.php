<?php
// src/QueueManager.php
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class QueueManager
{
    private $connection;
    private $channel;
    private $queueName;

    public function __construct()
    {
        $config = require '../config/config.php';
        $rabbitmqConfig = $config['rabbitmq'];

        // Создаем подключение к RabbitMQ
        $this->connection = new AMQPStreamConnection(
            $rabbitmqConfig['host'], 
            $rabbitmqConfig['port'], 
            $rabbitmqConfig['user'], 
            $rabbitmqConfig['password']
        );

        $this->channel = $this->connection->channel();
        $this->queueName = $rabbitmqConfig['queue'];

        // Создаем очередь, если она еще не существует
        $this->channel->queue_declare($this->queueName, false, true, false, false);
    }

    public function addToQueue($message)
    {
         
        $data = json_encode($message);

    
        $msg = new AMQPMessage(
            $data,
            ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT] // Устанавливаем сообщение как постоянное
        );

   
        $this->channel->basic_publish($msg, '', $this->queueName);
    }

    public function getQueue()
    {
 
        return $this->channel;
    }

    public function close()
    {
        $this->channel->close();
        $this->connection->close();
    }
}

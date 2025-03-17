<?php
require_once __DIR__ . '/../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class StatementRequest {
    private $config;

    public function __construct() {
        $this->config = require __DIR__ . '/../config/rabbitmq.php';
    }

    public function validate($data) {
        return !empty($data['start_date']) && 
               !empty($data['end_date']) && 
               !empty($data['email']) && 
               filter_var($data['email'], FILTER_VALIDATE_EMAIL);
    }

    public function queueRequest($data) {
        $connection = new AMQPStreamConnection(
            $this->config['host'],
            $this->config['port'],
            $this->config['user'],
            $this->config['password']
        );
        
        $channel = $connection->channel();
        $channel->queue_declare($this->config['queue'], false, true, false, false);

        $msg = new AMQPMessage(json_encode($data), ['delivery_mode' => 2]);
        $channel->basic_publish($msg, '', $this->config['queue']);
        
        $channel->close();
        $connection->close();
    }
}
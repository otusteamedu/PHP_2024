<?php

require_once '../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use Src\StatusStorage;

$connection = new AMQPStreamConnection('MyRabbitMQ', 5672, 'admin', 'secret');
$channel = $connection->channel();
$channel->queue_declare('task_queue', false, true, false, false);

$callback = function ($msg) {
    $data = json_decode($msg->body, true);
    $id = $data['id'];
    try {
        sleep(5); // эмуляция обработки
        StatusStorage::updateStatus($id, 'done');
    } catch (Exception $e) {
        StatusStorage::updateStatus($id, 'failed');
    }
};

$channel->basic_qos(null, 1, null);
$channel->basic_consume('task_queue', '', false, false, false, false, $callback);

while ($channel->is_consuming()) {
    $channel->wait();
}
<?php

declare(strict_types=1);

use PhpAmqpLib\Connection\AMQPStreamConnection;

error_reporting(E_ALL ^ E_DEPRECATED);

require_once __DIR__ . '/../vendor/autoload.php';

$settings = \Common\Settings::buildFromEnvVars();
$rabbit = new \Common\RabbitWrapper(
    $settings->rabbitmqQueueName,
    new AMQPStreamConnection($settings->rabbitmqHost, $settings->rabbitmqPort, $settings->rabbitmqUser, $settings->rabbitmqPass)
);

$messageContent = file_get_contents('php://input');

$rabbit->sendMessage(\Common\MessageDTO::buildFromJSONString($messageContent));

$response = [
    'status' => 200,
    'message' => 'Message sent'
];

header('Content-Type: application/json; charset=utf-8');
echo  json_encode($response);

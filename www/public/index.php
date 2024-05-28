<?php

declare(strict_types=1);

error_reporting(E_ALL ^ E_DEPRECATED);

require_once __DIR__ . '/../vendor/autoload.php';

$rabbit = new \Common\RabbitWrapper();
$rabbit->initQueue();

$messageContent = file_get_contents('php://input');

$rabbit->sendMessage(\Common\MessageDTO::buildFromJSONString($messageContent));

$response = [
    'status' => 200,
    'message' => 'Message sent'
];

header('Content-Type: application/json; charset=utf-8');
echo  json_encode($response);
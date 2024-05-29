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

$count = $_GET['count'] ?? 100;

for ($i = 0; $i < $count; $i++) {
    $msg = new \Common\MessageDTO(
        "message text $i",
        "test@mail.com",
        "hukimato",
        false
    );
    $rabbit->sendMessage($msg);
    echo "Sent $msg->message" . PHP_EOL;
}

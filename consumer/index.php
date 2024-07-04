<?php
declare(strict_types=1);
sleep(5);
require_once dirname(__DIR__) .'/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;


$connection = new AMQPStreamConnection(
    getenv("RABBITMQ_HOST"),
    getenv("RABBITMQ_PORT"),
    getenv("RABBITMQ_USER"),
    getenv("RABBITMQ_PASSWORD")
);

$channel = $connection->channel();

$channel->queue_declare(getenv("RABBITMQ_QUEUE_NAME"), false, false, false, null);

echo " [*] Waiting for messages. To exit press CTRL+C\n";

$callback = function ($msg) {
    echo " [x] Received ", $msg->body, "\n";
};

$channel->basic_consume(
    getenv("RABBITMQ_QUEUE_NAME"),
    '',
    false,
    true,
    false,
    false,
    $callback
);

while ($channel->is_consuming()) {
    $channel->wait();
}

$channel->close();
$connection->close();
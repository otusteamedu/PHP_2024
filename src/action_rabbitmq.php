<?php
declare(strict_types=1);
require_once __DIR__ . '/../vendor/autoload.php';

//Silence is gold
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;


echo " <a href='/'>Back to input</a><br><br>";

if(isset($_POST)){

    $json = json_encode($_POST);

    $connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');
    $channel = $connection->channel();

    $channel->queue_declare('otus', false, false, false, false);

    $msg = new AMQPMessage($json);
    $channel->basic_publish($msg, '', 'otus');

    echo $json;

    $channel->close();
    $connection->close();
}

echo "<br><br><a href='/handle_rabbitmq.php'>Handle request</a><br><br>";
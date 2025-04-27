<?php
require_once '../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

try {
    // Validate input
    if (!isset($_POST['start_date']) || !isset($_POST['end_date'])) {
        throw new Exception('Please provide both start and end dates');
    }

    // Connect to RabbitMQ
    $connection = new AMQPStreamConnection('rabbitmq', 5672, 'admin', 'secret');
    $channel = $connection->channel();

    // Declare queue
    $queue = 'statement_requests';
    $channel->queue_declare($queue, false, true, false, false);

    // Prepare message
    $data = [
        'start_date' => $_POST['start_date'],
        'end_date' => $_POST['end_date'],
        'timestamp' => date('Y-m-d H:i:s')
    ];

    // Publish message
    $msg = new AMQPMessage(json_encode($data), ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]);
    $channel->basic_publish($msg, '', $queue);

    // Clean up
    $channel->close();
    $connection->close();

    // Redirect with success message
    header('Location: index.php?success=1');
    exit;

} catch (Exception $e) {
    http_response_code(500);
    echo 'Error: ' . $e->getMessage();
}
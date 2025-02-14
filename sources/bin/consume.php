#!/usr/bin/env php
<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Infrastructure\Messaging\RabbitMqMessageConsumer;

// TODO env
$consumer = new RabbitMqMessageConsumer(
    'rabbitmq',
    5672,
    'guest',
    'guest',
    'task_queue'
);

$consumer->consume();

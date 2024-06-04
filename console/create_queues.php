<?php

declare(strict_types=1);

use App\ConnectionCreator;
use App\Consumer;
use App\Dictionaries\QueueDictionary;

require __DIR__ . '/../vendor/autoload.php';

$connection = ConnectionCreator::create();
$consumer = new Consumer($connection);

$queues = QueueDictionary::map();
foreach ($queues as $queue) {
    $consumer->declare($queue);
}

echo "Очереди успешно созданы." . PHP_EOL;

<?php

declare(strict_types=1);

use App\Infrastructure\Console\Callback\TransactionReportCallback;
use App\Infrastructure\Console\Consumer\TransactionConsumer;
use App\Infrastructure\Console\QueueConnection;

require __DIR__ . '/../Support/helpers.php';
require __DIR__ . '/../../../vendor/autoload.php';

ini_set('memory_limit', '8024M');

try {
    $connection = new QueueConnection();
    $callback = new TransactionReportCallback();
    $consume = new TransactionConsumer($connection, $callback);
    $consume->consume();
} catch (Exception $e) {
    echo $e->getMessage();
}

<?php

declare(strict_types=1);

use Predis\Client as RedisClient;
use App\Application\Services\QueueService;

require __DIR__ . '/../../../vendor/autoload.php';

$config = require __DIR__ . '/../../../app/Infrastructure/config/config.php';

$redis = new RedisClient($config['redis']);
$queueService = new QueueService($redis);

echo 'Worker started. Processing queue...' . PHP_EOL;

while (true) {
    $queueService->processQueue();
    sleep(1);
}
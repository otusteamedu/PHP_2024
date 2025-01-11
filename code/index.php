<?php

require 'vendor/autoload.php';

use Predis\Client;
use App\Storage\RedisEventStorage;

// Инициализация Redis клиента
$redis = new Client([
    'scheme' => 'tcp',
    'host' => 'redis',
    'port' => 6379,
]);

// Проверка подключения
try {
    $redis->connect();
    echo "Connected to Redis successfully." . "<br />";
} catch (Exception $e) {
    echo "Could not connect to Redis: " . $e->getMessage() . "<br />";
    exit(1);
}

// Создание экземпляра хранилища событий
$storage = new RedisEventStorage($redis);

// Добавление событий
$storage->addEvent([
    'priority' => 1000,
    'conditions' => ['param1' => 1],
    'event' => 'Event 1'
]);

$storage->addEvent([
    'priority' => 2000,
    'conditions' => ['param1' => 2, 'param2' => 2],
    'event' => 'Event 2'
]);

$storage->addEvent([
    'priority' => 3000,
    'conditions' => ['param1' => 1, 'param2' => 2],
    'event' => 'Event 3'
]);

echo "Events added to Redis." . "<br />";

// Получение наиболее подходящего события
$params = ['param1' => 1, 'param2' => 2];
$bestEvent = $storage->getBestMatchingEvent($params);

if ($bestEvent) {
    echo "Best matching event: " . $bestEvent['event'] . "<br />";
} else {
    echo "No matching event found." . "<br />";
}

// Очистка событий

$storage->clearEvents();
$bestEvent = $storage->getBestMatchingEvent($params);
echo "Events cleared." . "<br />";

if ($bestEvent) {
    echo "Best matching event: " . $bestEvent['event'] . "<br />";
} else {
    echo "No matching event found." . "<br />";
}

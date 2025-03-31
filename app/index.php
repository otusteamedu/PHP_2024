<?php

use Aware\App\Application\Event\EventService;
use Aware\App\Infrastructure\Event\EventRedisRepository;

require 'vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->loadEnv(__DIR__ . '/../.env');

$eventService = new EventService(new EventRedisRepository());

$event = [
    'priority' => 100,
    'conditions' => ['param1' => 1, 'param2' => 2],
    'events' => ['event1', 'event3'],
];

$event2 = [
    'priority' => 300,
    'conditions' => ['param1' => 1, 'param2' => 2],
    'events' => ['event1', 'event4'],
];

$event3 = [
    'priority' => 400,
    'conditions' => ['param1' => 1, 'param2' => 3],
    'events' => ['event1', 'event5'],
];

$conditions = ['param1' => 1, 'param2' => 2];

try {
    $eventService->deleteEvents();

    $eventService->addEvent($event);
    $eventService->addEvent($event2);
    $eventService->addEvent($event3);

    $bestEvent = $eventService->getBestEvent($conditions);

    var_dump($bestEvent);
} catch (Exception $e) {
    echo $e->getMessage();
}

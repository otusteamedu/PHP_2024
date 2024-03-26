<?php

declare(strict_types=1);

use AleksandrOrlov\Php2024\Event;
use AleksandrOrlov\Php2024\Storage\RedisStorage;

require_once __DIR__ . '/vendor/autoload.php';

$event = new Event(new RedisStorage());
$options = getopt('p:c:e::g');

$priority = 0;
$conditions = [];
$eventName = '';

if (!empty($options['p'])) {
    $priority = $options['p'];
}
if (!empty($options['c'])) {
    $conditions = json_decode($options['c'], true);
}
if (!empty($options['e'])) {
    $eventName = $options['e'];
}

try {
    if (!empty($priority) && !empty($conditions) && !empty($eventName)) {
        $event->add($priority, $conditions, $eventName);
    } elseif (isset($options['g']) && !empty($conditions)) {
        $event = $event->get($conditions);
        echo $event . PHP_EOL;
    }
} catch (Exception $e) {
    echo $e->getMessage();
}

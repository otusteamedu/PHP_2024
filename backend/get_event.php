<?php

require 'vendor/autoload.php';

use Service\RedisEvent;

$eventSystem = new RedisEvent();

$params = [
    'param1' => 1,
    'param2' => 2,
];

$bestEvent = $eventSystem->getBestMatchingEvent($params);

try {
    $bestEvent = $eventSystem->getBestMatchingEvent($params);
    if ($bestEvent) {
        echo "Best matching event: " . $bestEvent['event'];
    } else {
        echo "No matching event found.";
    }
} catch (\Exception $e) {
    echo "An error occurred: " . $e->getMessage();
}

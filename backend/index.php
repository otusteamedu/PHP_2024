<?php

require 'vendor/autoload.php';

use Service\RedisConnection;
use Service\RedisEvent;

$redisConnection = new RedisConnection();
$redis = $redisConnection->getRedis();

$eventSystem = new RedisEvent($redis);

$command = $argv[1] ?? null;

switch ($command) {
    case 'add':
        $priority = (int)$argv[2];
        $conditions = json_decode($argv[3], true);
        $event = $argv[4];
        $eventSystem->addEvent($priority, $conditions, $event);
        echo "Event added.\n";
        break;

    case 'clear':
        $eventSystem->clearEvents();
        echo "All events cleared.\n";
        break;

    case 'get':
        $params = json_decode($argv[2], true);
        $bestEvent = $eventSystem->getBestMatchingEvent($params);
        if ($bestEvent) {
            echo "Best matching event: " . $bestEvent['event'] . "\n";
        } else {
            echo "No matching event found.\n";
        }
        break;

    default:
        echo "Unknown command. Use 'add', 'clear' or 'get'.\n";
}

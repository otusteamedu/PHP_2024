<?php

require 'vendor/autoload.php';

use Service\RedisEvent;

$eventSystem = new RedisEvent();

$eventSystem->addEvent(1000, ['param1' => 1], 'Event 1');
$eventSystem->addEvent(2000, ['param1' => 2, 'param2' => 2], 'Event 2');
$eventSystem->addEvent(3000, ['param1' => 1, 'param2' => 2], 'Event 3');

echo "Events added successfully.";

<?php

require 'vendor/autoload.php';

use Service\RedisEvent;

$eventSystem = new RedisEvent();

$eventSystem->clearEvents();

echo "Events were erased successfully.";

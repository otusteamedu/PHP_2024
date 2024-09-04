<?php

declare(strict_types=1);

use function Redis\{getRedisConnectionStatusMessage};
use function Session\{getCounterValue, incrementCounter, startSession};

require_once __DIR__ . '/../functions.php';

startSession();

incrementCounter();

echo '<p>PHP-FPM container ID: <b>' . $_SERVER['HOSTNAME'] . '</b><p>';

echo '<p>Redis connection status: <b>' . getRedisConnectionStatusMessage() . '</b>';

echo '<p>Current counter value in session (Redis): <b>' . getCounterValue() . '</b></p>';

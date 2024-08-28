<?php

declare(strict_types=1);

session_start();

require_once __DIR__ . '/vendor/autoload.php';

use TimurShakirov\Hw4\Application;
use TimurShakirov\Hw4\RedisSessionHandler;

echo (new Application())->run();

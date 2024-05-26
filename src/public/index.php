<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/constants.php';

use AlexanderGladkov\CleanArchitecture\Infrastructure\Web\Application\Application;

$container = require CONTAINER_CONFIG_DIR . '/container.php';
(new Application($container))->run();



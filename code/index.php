<?php

declare(strict_types=1);

use Viking311\Api\Infrastructure\Application;

require __DIR__ . "/vendor/autoload.php";

$app = new Application();

$app->run();

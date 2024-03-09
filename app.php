<?php

declare(strict_types=1);

require_once __DIR__ . "/vendor/autoload.php";

try {
    $app = Main\App::getInstance();
    $app->run($argv);
} catch (\Throwable $e) {
    echo $e->getMessage() . PHP_EOL;
}

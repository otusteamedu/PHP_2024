<?php

declare(strict_types=1);

use Viking311\Queue\Infrastructure\Console;

require "./vendor/autoload.php";

$app = new Console();

try {
    $app->run();
} catch (Exception $ex) {
    echo 'Error: ' . $ex->getMessage() . PHP_EOL;
}

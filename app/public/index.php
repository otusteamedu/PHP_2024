<?php

declare(strict_types=1);

use Hinoho\Battleship\App;

require __DIR__ . '/../vendor/autoload.php';

try {
    $app = new App();
    $app->run();
} catch (Exception $e) {
    echo 'error: ' . $e->getMessage() . "\n";
}
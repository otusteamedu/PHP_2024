<?php

declare(strict_types=1);

use Kagirova\Hw14\App;

require __DIR__ . '/../vendor/autoload.php';

try {
    $app = new App();
    $app->run();
} catch (Exception $e) {
    echo 'error: ' . $e->getMessage() . "\n";
}

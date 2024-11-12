<?php

require_once __DIR__ . '/../vendor/autoload.php';

use VSukhov\Hw12\App\App;

try {
    $app = new App();
    $app->run(array_slice($argv, 1));
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

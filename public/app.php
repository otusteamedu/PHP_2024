<?php

declare(strict_types=1);

use Afilippov\Hw5\App;

require '../vendor/autoload.php';

try {
    $app = new App();
    $app->run($argv[1] ?? null);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}

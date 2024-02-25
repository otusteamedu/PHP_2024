<?php

declare(strict_types=1);

use Afilipov\Hw6\App;

require '../vendor/autoload.php';

try {
    $app = new App();
    $app->run();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}

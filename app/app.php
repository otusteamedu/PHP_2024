<?php

declare(strict_types=1);

use Dsergei\Hw11\App;

require 'vendor/autoload.php';

try {
    $app = new App();
    echo $app->run();
} catch (Throwable $e) {
    echo $e->getFile() . PHP_EOL;
    echo $e->getLine() . PHP_EOL;
    echo "Error: " . $e->getMessage() . PHP_EOL;
}

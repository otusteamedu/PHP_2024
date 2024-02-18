<?php

declare(strict_types=1);

require('vendor/autoload.php');

use Dsergei\Hw5\App;

try {
    $app = new App();
    $app->run($argv[1] ?? null);
} catch (Exception $e) {
    echo "Error: {$e->getMessage()}" . PHP_EOL;
}

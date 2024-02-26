<?php

declare(strict_types=1);

require('vendor/autoload.php');

use Dsergei\Hw6\App;

try {
    $app = new App();
    $app->run();
} catch (Exception $e) {
    echo "Error: {$e->getMessage()}" . PHP_EOL;
}

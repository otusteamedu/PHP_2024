<?php

declare(strict_types=1);

require_once(__DIR__ . '/vendor/autoload.php');

use Otus\Hw6\App;

try {
    $app = new App();
    $app->run();
    echo $app->getMessage();
} catch (\Exception $e) {
    echo "ERROR: {$e->getMessage()}" . PHP_EOL;
}

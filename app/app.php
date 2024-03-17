<?php

declare(strict_types=1);

require_once(__DIR__ . '/vendor/autoload.php');

use Otus\Hw5\App;

try {
    (new App())->run();
} catch (\Exception $e) {
    echo "ERROR: {$e->getMessage()}" . PHP_EOL;
}

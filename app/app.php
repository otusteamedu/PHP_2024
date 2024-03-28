<?php

declare(strict_types=1);

use App\Base;

require __DIR__ . '/vendor/autoload.php';

try {
    $app = new Base();
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}

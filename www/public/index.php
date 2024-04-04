<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Hukimato\App\App;

try {
    $app = new App();
    $app->run();
} catch (Throwable $e) {
    echo $e->getMessage() . PHP_EOL;
}

<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use AShutov\Hw5\App;

try {
    $app = new App();
    $app->run($argv[1] ?? null);
} catch (Throwable $e) {
    echo $e->getMessage();
}

<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use AShutov\Hw6\App;

try {
    $filePath = 'emails.txt';
    $app = new App();
    echo $app->run($filePath);
} catch (Throwable $e) {
    echo $e->getMessage();
}

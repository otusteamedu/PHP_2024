<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use AShutov\Hw14\App;

try {
    $app = new App();
    $app->run($argv[1] ?? null);

    foreach ($app->getAnswer() as $answer) {
        echo $answer . PHP_EOL;
    }
} catch (Throwable $e) {
    echo $e->getMessage();
}

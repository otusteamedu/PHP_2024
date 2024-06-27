<?php

declare(strict_types=1);

use App\Infrastructure\Consumer;
use DI\ContainerBuilder;

require __DIR__ . '/../../vendor/autoload.php';

try {
    $containerBuilder = new ContainerBuilder();

    if (false) { // Should be set to true in production
        $containerBuilder->enableCompilation(__DIR__ . '/../../var/cache');
    }
    $dependencies = require __DIR__ . '/../../app/dependencies.php';
    $dependencies($containerBuilder);
    $container = $containerBuilder->build();
    $consumer = $container->get(Consumer::class);
    $consumer->listenQueue();
} catch (Exception $e) {
    print_r($e->getMessage());
}

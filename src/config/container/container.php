<?php

declare(strict_types=1);

require_once __DIR__ . '/../constants.php';

use DI\ContainerBuilder;

try {
    $containerBindings = require CONTAINER_CONFIG_DIR . '/container_bindings.php';
    $containerBuilder = new ContainerBuilder();
    $containerBuilder->addDefinitions($containerBindings);
    return $containerBuilder->build();
} catch (Exception $e) {
    echo $e->getMessage();
    exit(0);
}

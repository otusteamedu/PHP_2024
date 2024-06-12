<?php

declare(strict_types=1);

// Instantiate PHP-DI ContainerBuilder
use DI\ContainerBuilder;

$containerBuilder = new ContainerBuilder();

if (false) { // Should be set to true in production
    $containerBuilder->enableCompilation(PROJECT_ROOT . '/var/cache');
}

// Set up settings
$settings = require PROJECT_ROOT . '/app/settings.php';
$settings($containerBuilder);

// Set up dependencies
$dependencies = require PROJECT_ROOT . '/app/dependencies.php';
$dependencies($containerBuilder);

// Build PHP-DI Container instance
return $containerBuilder->build();
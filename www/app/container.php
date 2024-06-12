<?php

declare(strict_types=1);

// Instantiate PHP-DI ContainerBuilder
use DI\ContainerBuilder;

$containerBuilder = new ContainerBuilder();


if ((getenv('ENV') ?? 'production') === 'production') { // Should be set to true in production
    $containerBuilder->enableCompilation(__DIR__ . '/var/cache');
}

// Set up settings
$settings = require __DIR__ . '/settings.php';
$settings($containerBuilder);

// Set up dependencies
$dependencies = require __DIR__ . '/dependencies.php';
$dependencies($containerBuilder);

$doctrine = require __DIR__ . '/doctrine.php';
$doctrine($containerBuilder);

$generator = require __DIR__ . '/generator.php';
$generator($containerBuilder);

$queue = require __DIR__ . '/queue.php';
$queue($containerBuilder);

$storage = require __DIR__ . '/storages.php';
$storage($containerBuilder);

// Build PHP-DI Container instance
$container = $containerBuilder->build();

return $container;

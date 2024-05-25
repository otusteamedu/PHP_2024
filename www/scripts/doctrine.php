<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;

require __DIR__ . '/../vendor/autoload.php';

// Instantiate PHP-DI ContainerBuilder
$containerBuilder = new ContainerBuilder();

$settings = require __DIR__ . '/../app/settings.php';
$settings($containerBuilder);

$doctrine = require __DIR__ . '/../app/doctrine.php';
$doctrine($containerBuilder);

$container = $containerBuilder->build();

$em = $container->get(EntityManager::class);

ConsoleRunner::run(
    new SingleManagerProvider($em),
    []
);

# php scripts/doctrine.php orm:schema-tool:create
# php scripts/doctrine.php orm:schema-tool:drop --force
# php scripts/doctrine.php orm:schema-tool:update --force

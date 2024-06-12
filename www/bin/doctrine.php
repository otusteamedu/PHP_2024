<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;

require __DIR__ . '/../vendor/autoload.php';

$container = require_once __DIR__ . '/../app/container.php';

$em = $container->get(\Doctrine\ORM\EntityManagerInterface::class);

ConsoleRunner::run(
    new SingleManagerProvider($em),
    []
);

# php bin/doctrine.php orm:schema-tool:create
# php bin/doctrine.php orm:schema-tool:drop --force
# php bin/doctrine.php orm:schema-tool:update --force

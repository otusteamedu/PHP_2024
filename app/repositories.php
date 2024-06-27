<?php

declare(strict_types=1);

use App\Domain\CustomerTask\TaskRepositoryInterface;
use App\Infrastructure\CustomerTask\CustomerTaskRepository;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our TaskRepository interface to its in memory implementation
    $containerBuilder->addDefinitions([
        TaskRepositoryInterface::class => \DI\autowire(CustomerTaskRepository::class),
    ]);
};

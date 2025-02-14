<?php

declare(strict_types=1);

use App\Domain\Repository\TaskRepositoryInterface;
use App\Infrastructure\Persistence\TaskRepository;
use DI\ContainerBuilder;
use function DI\autowire;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        TaskRepositoryInterface::class => autowire(TaskRepository::class),
    ]);
};

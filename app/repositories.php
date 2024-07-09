<?php

declare(strict_types=1);

use App\Domain\Entity\ApiRequest\ApiRequestRepositoryInterface;
use App\Infrastructure\Persistence\Repository\DatabaseApiRequestRepository;
use DI\ContainerBuilder;

use function DI\autowire;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our UserRepository interface to its in memory implementation
    $containerBuilder->addDefinitions([
        ApiRequestRepositoryInterface::class => autowire(DatabaseApiRequestRepository::class),
    ]);
};

<?php

declare(strict_types=1);

use App\Domain\Entity\News\NewsRepositoryInterface;
use App\Infrastructure\Persistence\Repository\DatabaseNewsRepository;
use DI\ContainerBuilder;

use function DI\autowire;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        NewsRepositoryInterface::class => autowire(DatabaseNewsRepository::class),
    ]);
};

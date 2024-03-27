<?php

declare(strict_types=1);

namespace Rmulyukov\Hw11\Application;

use Rmulyukov\Hw11\Application\Dto\ItemsDto;
use Rmulyukov\Hw11\Application\Repository\ShopCommandRepositoryInterface;
use Rmulyukov\Hw11\Application\Repository\ShopQueryRepositoryInterface;
use Rmulyukov\Hw11\Application\Query\QueryParser;

final readonly class App
{
    public function __construct(
        private Config $config,
        private ShopCommandRepositoryInterface $commandRepository,
        private ShopQueryRepositoryInterface $queryRepository,
    ) {
    }

    public function run(array $argv): array
    {
        $config = $this->config;
        return match ($argv[1] ?? null) {
            'init' => $this->commandRepository->initStorage($config->getStorageName(), $config->getStorageSettings()),
            'seed' => $this->commandRepository->addItems(
                $config->getStorageName(),
                new ItemsDto(file_get_contents($config->getSeedFilePath()))
            ),
            'query' => $this->queryRepository->findAll(
                $config->getStorageName(),
                (new QueryParser())->createQuery($argv)
            )
        };
    }
}

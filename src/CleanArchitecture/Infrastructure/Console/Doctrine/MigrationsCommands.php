<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Infrastructure\Console\Doctrine;

use Doctrine\Migrations\Configuration\Migration\ConfigurationArray;
use Doctrine\Migrations\Tools\Console\Command\DiffCommand;
use Doctrine\ORM\EntityManager;
use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Tools\Console\Command\CurrentCommand;
use Doctrine\Migrations\Tools\Console\Command\DumpSchemaCommand;
use Doctrine\Migrations\Tools\Console\Command\ExecuteCommand;
use Doctrine\Migrations\Tools\Console\Command\GenerateCommand;
use Doctrine\Migrations\Tools\Console\Command\LatestCommand;
use Doctrine\Migrations\Tools\Console\Command\ListCommand;
use Doctrine\Migrations\Tools\Console\Command\MigrateCommand;
use Doctrine\Migrations\Tools\Console\Command\RollupCommand;
use Doctrine\Migrations\Tools\Console\Command\StatusCommand;
use Doctrine\Migrations\Tools\Console\Command\SyncMetadataCommand;
use Doctrine\Migrations\Tools\Console\Command\UpToDateCommand;
use Doctrine\Migrations\Tools\Console\Command\VersionCommand;

class MigrationsCommands
{
    public function __construct(private array $migrationsConfig, private EntityManager $entityManager)
    {
    }

    public function getList(): array
    {
        $dependencyFactory = $this->getDependencyFactory();
        return [
            new CurrentCommand($dependencyFactory),
            new DumpSchemaCommand($dependencyFactory),
            new ExecuteCommand($dependencyFactory),
            new GenerateCommand($dependencyFactory),
            new LatestCommand($dependencyFactory),
            new MigrateCommand($dependencyFactory),
            new RollupCommand($dependencyFactory),
            new StatusCommand($dependencyFactory),
            new VersionCommand($dependencyFactory),
            new UpToDateCommand($dependencyFactory),
            new SyncMetadataCommand($dependencyFactory),
            new ListCommand($dependencyFactory),
            new DiffCommand($dependencyFactory)
        ];
    }

    private function getDependencyFactory(): DependencyFactory
    {
        $config = new ConfigurationArray($this->migrationsConfig);
        return DependencyFactory::fromEntityManager($config, new ExistingEntityManager($this->entityManager));
    }
}

<?php

declare(strict_types=1);

namespace Rmulyukov\Hw;

use Rmulyukov\Hw\Application\Factory\EventFactory;
use Rmulyukov\Hw\Application\Repository\EventCommandRepositoryInterface;
use Rmulyukov\Hw\Application\Repository\EventQueryRepositoryInterface;
use RuntimeException;

final class Config
{
    private string $storage;
    private EventCommandRepositoryInterface $commandRepository;
    private EventQueryRepositoryInterface $queryRepository;
    private string $storageHost;
    private int $storagePort;

    public function __construct(array $config)
    {
        $this->ensureCorrectParams($config);
        $this->storage = $config['storage'];
        $storageParams = $config[$config['storage']];
        $this->storageHost = $storageParams['host'];
        $this->storagePort = (int) $storageParams['port'];
        $this->commandRepository = new $storageParams['commandRepository']($this->storageHost, $this->storagePort);
        $this->queryRepository = new $storageParams['queryRepository'](
            new EventFactory(),
            $this->storageHost,
            $this->storagePort
        );
    }

    private function ensureCorrectParams(array $config): void
    {
        if (!isset($config['storage'], $config[$config['storage']])) {
            throw new RuntimeException("Storage type and storage configs must be set");
        }

        $storage = $config[$config['storage']];
        if (
            !is_array($storage) ||
            !isset($storage['host'], $storage['port'], $storage['commandRepository'], $storage['queryRepository'])
        ) {
            throw new RuntimeException("Storage config must be an array with [host, port, commandRepository, queryRepository] keys");
        }
    }

    public function getStorage(): string
    {
        return $this->storage;
    }

    public function getCommandRepository(): EventCommandRepositoryInterface
    {
        return $this->commandRepository;
    }

    public function getQueryRepository(): EventQueryRepositoryInterface
    {
        return $this->queryRepository;
    }
}

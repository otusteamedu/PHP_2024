<?php

declare(strict_types=1);

namespace Rmulyukov\Hw11\Application;

use RuntimeException;

final readonly class Config
{
    private string $basePath;
    private string $seedFile;
    private string $elasticHost;
    private string $storageName;
    private array $storageSettings;

    public function __construct(array $config)
    {
        $this->ensureParamsExist($config);
        $this->basePath = $config['basePath'];
        $this->seedFile = $config['seedFile'];
        $this->elasticHost = $config['elasticHost'];
        $this->storageName = $config['storageName'];
        $this->storageSettings = $config['storageSettings'];
    }

    public function getBasePath(): string
    {
        return $this->basePath;
    }

    public function getSeedFilePath(): string
    {
        return $this->getBasePath() . trim($this->seedFile, '/');
    }

    public function getElasticHost(): string
    {
        return $this->elasticHost;
    }

    public function getStorageName(): string
    {
        return $this->storageName;
    }

    public function getStorageSettings(): array
    {
        return $this->storageSettings;
    }

    private function ensureParamsExist(array $config): void
    {
        $expectedParams = ['basePath', 'seedFile', 'elasticHost', 'storageName', 'storageSettings'];
        foreach ($expectedParams as $param) {
            if (!isset($config[$param])) {
                throw new RuntimeException("Configuration attribute '$param' must be set");
            }
        }
        if (!is_array($config['storageSettings'])) {
            throw new RuntimeException("Storage settings configuration must be an array");
        }
    }
}

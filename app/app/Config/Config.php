<?php

declare(strict_types=1);

namespace Rmulyukov\Hw5\Config;

use Exception;

final readonly class Config
{
    private array $configs;
    private string $basePath;
    private string $socketFile;
    /**
     * @throws Exception
     */
    public function __construct(string $configFile)
    {
        if (!file_exists($configFile)) {
            throw new Exception("Config file $configFile not exist");
        }
        $this->configs = require_once $configFile;
        $this->basePath = $this->getString('basePath', __DIR__);
        $this->socketFile = $this->getString('socketFile', 'server.sock');
    }

    /**
     * @throws Exception
     */
    private function getString(string $key, string $default): string
    {
        if (!isset($this->configs[$key])) {
            return $default;
        }
        if (!is_string($this->configs[$key])) {
            throw new Exception("Config $key is not string");
        }
        return $this->configs[$key];
    }

    public function getBasePath(): string
    {
        return $this->basePath;
    }

    public function getSocketFile(): string
    {
        return $this->socketFile;
    }

    public function getStoragePath(): string
    {
        return $this->basePath . '/../storage';
    }
}

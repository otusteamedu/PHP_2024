<?php

declare(strict_types=1);

namespace Rmulyukov\Hw5\Config;

use Exception;

final readonly class Config
{
    private array $configs;

    /**
     * @throws Exception
     */
    public function __construct(string $configFile)
    {
        if (!file_exists($configFile)) {
            throw new Exception("Config file $configFile not exist");
        }
        $this->configs = require_once $configFile;
    }

    /**
     * @throws Exception
     */
    public function getString(string $key, string $default): string
    {
        if (!isset($this->configs[$key])) {
            return $default;
        }
        if (!is_string($this->configs[$key])) {
            throw new Exception("Config $key is not string");
        }
        return $this->configs[$key];
    }
}

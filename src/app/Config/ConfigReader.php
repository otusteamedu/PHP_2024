<?php

declare(strict_types=1);

namespace App\Config;

use RuntimeException;

readonly class ConfigReader
{
    public static function init(string $path): self
    {
        return new self(self::loadConfig($path));
    }

    public function getConfig(?string $key = null, mixed $default = null): mixed
    {
        if ($key === null) {
            return $this->config;
        }

        return $this->config[$key] ?? $default;
    }

    private function __construct(
        private array $config
    ) {
    }

    private static function loadConfig(string $path): array
    {
        if (!file_exists($path) || !is_readable($path)) {
            throw new RuntimeException('Config file does not exist or is not readable');
        }

        $config = parse_ini_file($path);

        if ($config === false) {
            throw new RuntimeException('Could not parse the configuration file');
        }

        return $config;
    }
}

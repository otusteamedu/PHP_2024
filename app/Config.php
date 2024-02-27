<?php

declare(strict_types=1);

namespace Pozys\ChatConsole;

use Exception;

class Config
{
    public readonly string $socketPath;
    public readonly string $stopWord;

    public function __construct(string $configPath)
    {
        $config = $this->getConfig($configPath);
        $this->initConfigValues($config);
    }

    private function getConfig(string $configPath): array
    {
        if (!file_exists($configPath)) {
            throw new Exception("Config file not found at path: $configPath");
        }

        $config = parse_ini_file($configPath, true);

        if ($config === false) {
            throw new Exception("Wrong config file");
        }

        return $config;
    }

    private function initConfigValues(array $config): void
    {
        $socket = $config['socket'] ?? [];
        $this->socketPath = $socket['path'] ?? '';
        $this->stopWord = $socket['stop_word'] ?? '';
    }
}

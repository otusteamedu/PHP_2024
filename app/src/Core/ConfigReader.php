<?php

declare(strict_types=1);

namespace Dsmolyaninov\Hw5\Core;

class ConfigReader
{
    /**
     * @var string[]
     */
    private array $config = [];

    public function __construct(string $configFilePath = __DIR__ . '/../../config.ini')
    {
        $this->loadConfig($configFilePath);
    }

    private function loadConfig(string $configFilePath): void
    {
        if (!file_exists($configFilePath) || !is_readable($configFilePath)) {
            throw new \RuntimeException('Файл конфигурации не найден или недоступен для чтения');
        }

        $parsedConfig = parse_ini_file($configFilePath);
        if ($parsedConfig === false) {
            throw new \RuntimeException('Ошибка при чтении файла конфигурации');
        }
        $this->config = $parsedConfig;
    }

    public function getValue(string $key, string $default = null): string
    {
        if (!array_key_exists($key, $this->config)) {
            if ($default !== null) {
                return $default;
            }
            throw new \RuntimeException("Ключ '$key' не найден в конфигурации");
        }

        return $this->config[$key];
    }
}

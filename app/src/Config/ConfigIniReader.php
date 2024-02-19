<?php

declare(strict_types=1);

namespace Dw\OtusSocketChat\Config;

use Exception;

class ConfigIniReader implements ConfigInterface
{
    protected string $configFile = 'config/config.ini';
    protected array $config = [];

    /**
     * @throws Exception
     */
    public function __construct()
    {
        if (!file_exists($this->configFile)) {
            throw new Exception('Файл конфигурации не найден');
        }

        $this->config = parse_ini_file($this->configFile, true);
        if ($this->config === false) {
            throw new Exception('Ошибка получения конфигурации');
        }
    }

    public function getConfiguration(): array
    {
        return $this->config;
    }
}

<?php
declare(strict_types=1);

namespace App\Infrastructure\Config;

class Config
{
    private const CONFIG_PATH = __DIR__.'/config.ini';
    private array $config;

    public function __construct()
    {
        $this->config = parse_ini_file(self::CONFIG_PATH,true);
    }

    public function getSection(string $config_section): array|string
    {
        if (!array_key_exists($config_section,$this->config)) {
            return "Секция не найдена в конфиге.";
        }
        return $this->config[$config_section];
    }

}
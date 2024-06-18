<?php
declare(strict_types=1);

namespace App\Infrastructure\Config;

class Config
{
    private const CONFIG_PATH = __DIR__.'/config.ini';
    private array $config;

    public readonly array $sections;

    public function __construct()
    {
        $this->config = parse_ini_file(self::CONFIG_PATH,true);
        $this->sections = array_keys($this->config);
    }

    public function getSection(string $config_section): array|string
    {
        if (!in_array($config_section, $this->sections, true)) {
            return "Секция не найдена в конфиге.";
        }
        return $this->config[$config_section];
    }

}
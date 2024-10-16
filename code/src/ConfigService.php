<?php

namespace Naimushina\ElasticSearch;

class ConfigService
{
    private array $configs;

    /**
     * @param string $configFile
     */
    public function __construct(string $configFile = 'config.php')
    {
        $this->configs = include ($configFile);
    }

    /**
     * @param string $name Ключ необходимых параметров
     * @return array
     */
    public function getConfigByName(string $name): array
    {
        return $this->configs[$name];
    }
}
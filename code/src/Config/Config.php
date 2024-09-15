<?php

declare(strict_types=1);

namespace Viking311\Chat\Config;

class Config
{
    public readonly string $socketPath;


    /**
     * @throws ConfigException
     */
    public function __construct(string $configPath = '')
    {
        if (empty($configPath)) {
            $configPath = __DIR__ . '/../../app.ini';
        }

        if (!file_exists($configPath)) {
            throw new ConfigException("File $configPath not exists");
        }

        $cfg = parse_ini_file($configPath);
        if ($cfg === false) {
            throw new ConfigException('Cannot parse app ini file');
        }

        if (!array_key_exists('socket_path', $cfg) || empty($cfg['socket_path'])) {
            throw new ConfigException('Socket path is not set');
        }
        $this->socketPath = $cfg['socket_path'];
    }
}

<?php

declare(strict_types=1);

namespace Viking311\Chat\Config;

class Config
{
    private string $socketPath;


    /**
     * @throws ConfigException
     */
    public function __construct()
    {
        $cfg = parse_ini_file(__DIR__ . '/../../app.ini');
        if ($cfg === false) {
            throw new ConfigException('Cannot parse app ini file');
        }

        if (!array_key_exists('socket_path', $cfg) || empty($cfg['socket_path'])) {
            throw new ConfigException('Socket path is not set');
        }
        $this->socketPath = $cfg['socket_path'];
    }

    /**
     * @return string
     */
    public function getSocketPath(): string
    {
        return $this->socketPath;
    }
}

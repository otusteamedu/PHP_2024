<?php

namespace TBublikova\Php2024\config;

final readonly class SocketConfig
{
    public string $socketPath;

    public function __construct()
    {
        $configFile = dirname(__DIR__, 2) . '/config/socket.ini';

        if (!file_exists($configFile)) {
            throw new \RuntimeException('socket.ini not found');
        }

        $config = parse_ini_file($configFile);
        if (!isset($config['socketPath'])) {
            throw new \RuntimeException('socketPath not found in socket.ini');
        }

        $this->socketPath = $config['socketPath'];
    }
}

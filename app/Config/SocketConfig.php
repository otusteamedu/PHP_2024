<?php

namespace App\Config;

class SocketConfig
{
    private array $config;

    public function __construct()
    {
        $this->config = parse_ini_file(__DIR__ . '/../../config/socket.ini', true) ?? [];
    }

    public function get(string $key, $default = null): mixed
    {
        return $this->config[$key] ?? $default;
    }
}

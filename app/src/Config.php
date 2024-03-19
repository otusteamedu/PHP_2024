<?php

declare(strict_types=1);

namespace Lrazumov\Hw5;

use Exception;

class Config
{
    private string $config_path;
    private array $config;

    public function __construct(string $config_path)
    {
        if (!file_exists($config_path)) {
            throw new Exception("Config file $config_path not exist");
        }
        $this->config_path = $config_path;
    }

    public function load()
    {
        $config = parse_ini_file($this->config_path, true);
        if ($config === false) {
            throw new Exception("Config file parse error");
        }

        $this->config = $config;
    }

    public function getSocketPath()
    {
        if (empty($this->config['socket']['path'])) {
            throw new Exception("Config file: 'socket.path' not found");
        }
        return $this->config['socket']['path'];
    }
}

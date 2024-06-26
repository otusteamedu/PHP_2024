<?php

declare(strict_types=1);

namespace Otus\Chat;

class Config
{
    public readonly string $socketPath;

    public function __construct()
    {
        $configFile = __DIR__ . "/../config.ini";
        if (!file_exists($configFile)) {
            throw new \Exception('config.ini not found');
        }
        $config = parse_ini_file($configFile);
        $this->socketPath = $config["socketPath"];
    }
}

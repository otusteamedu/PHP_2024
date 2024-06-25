<?php

declare(strict_types=1);

namespace Otus\Chat;

class Controller
{
    public $clientPath;
    public $serverPath;

    public function __construct()
    {
        $configFile = __DIR__ . "/../config.ini";
        file_exists($configFile) || new Error('config.ini not found');
        $config = parse_ini_file($configFile);
        $this->clientPath = $config["clientPath"];
        $this->serverPath = $config["serverPath"];
    }
}

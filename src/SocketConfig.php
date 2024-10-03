<?php

declare(strict_types=1);

namespace Otus\SocketChat;

use Exception;

class SocketConfig implements Config
{
    public string $socketFile;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->getSocketFile();
    }

    /**
     * @throws Exception
     */
    private function getSocketFile(): void
    {
        $configFile = __DIR__ . "/config.ini";

        if (!file_exists($configFile)) {
            throw new Exception('config.ini не найден');
        }
        $config = parse_ini_file($configFile);

        $this->socketFile = $config["socketFile"];
    }
}

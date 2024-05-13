<?php

declare(strict_types=1);

namespace App\Config;

class SocketConfig
{
    private const KEY_PATH = 'PATH';
    private const KEY_MAX_LENGTH = 'MAX_LENGTH';

    private ConfigReader $configReader;

    public function __construct()
    {
        $this->configReader = ConfigReader::init(__DIR__ . '/../../config/socket.ini');
    }

    public function getPath(): string
    {
        return $this->configReader->getConfig(self::KEY_PATH, 'socket/chat.sock');
    }

    public function getMaxLength(): int
    {
        return (int) $this->configReader->getConfig(self::KEY_MAX_LENGTH, 1024);
    }
}
<?php

namespace VSukhov\Sockets\Socket;

use VSukhov\Sockets\Exception\AppException;

class Config
{
    private static ?Config $instance = null;
    private array $settings;

    /**
     * @throws AppException
     */
    private function __construct()
    {
        $settingsFile = dirname(__DIR__) . '../../config/config.ini';
        $this->settings = parse_ini_file($settingsFile);
        if (empty($this->settings['socket_path'])) {
            throw new AppException('Необходимо конфигурировать socket_path');
        }
    }

    private function __clone() {}

    /**
     * @throws AppException
     */
    public function __wakeup()
    {
        throw new AppException("Cannot unserialize a singleton.");
    }

    public static function getInstance(): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    public function getSocketPath(): ?string
    {
        return $this->settings['socket_path'] ?? null;
    }
}
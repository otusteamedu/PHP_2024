<?php

namespace Komarov\Hw5\App;

use Komarov\Hw5\Exception\AppException;

class Settings
{
    private static Settings|null $instance = null;
    private array $settings;

    /**
     * @throws AppException
     */
    private function __construct()
    {
        $settingsFile = dirname(__DIR__) . '../../config/config.ini';
        $this->settings = parse_ini_file($settingsFile);
        $this->validateSettings();
    }

    private function __clone()
    {
        // singleton
    }

    /**
     * @throws AppException
     */
    public function __wakeup()
    {
        throw new AppException("Cannot serialize singleton");
    }

    public static function getInstance(): self
    {
        if (is_null(self::$instance)) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * @throws AppException
     */
    private function validateSettings(): void
    {
        if (empty($this->settings['socket_path'])) {
            throw new AppException('socket_path is not set');
        }
    }

    public function getValue(string $key, $default = null): ?string
    {
        return $this->settings[$key] ?? $default;
    }
}

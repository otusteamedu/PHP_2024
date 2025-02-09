<?php

declare(strict_types=1);

namespace Apeskovatzkov\Hw5\Application;

class Configurator
{
    private static array $configuration;

    public function __construct(
        private string $configLocation = __DIR__ . '/../../config/app.ini',
    ) {
        $this->loadConfiguration();
    }

    public function getParam(string $key, string|int $default = ''): mixed
    {
        return self::$configuration[$key] ?? $default;
    }

    private function loadConfiguration(): void
    {
        if (!isset(self::$configuration)) {
            self::$configuration = parse_ini_file($this->configLocation);
        }
    }
}

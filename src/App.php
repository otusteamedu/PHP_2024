<?php

declare(strict_types=1);

namespace Pozys\ChatConsole;

use Exception;

class App
{
    public static function getConfig(string $name): mixed
    {
        $config = self::readConfig(dirname(__DIR__) . '/config/config.ini');

        $result = array_reduce(explode('.', $name), function ($carry, string $key) {
            if ($carry === null) {
                return null;
            }

            $carry = $carry[$key] ?? null;

            return $carry;
        }, $config);

        return $result;
    }

    public function run(): void
    {
        $appType = $this->readAppType();

        $app = match ($appType) {
            'server' => new Server(),
            'client' => new Client(),
            default => throw new Exception("Wrong app type", 1),
        };

        $app->run();
    }

    private function readAppType(): string
    {
        if ($_SERVER['argc'] !== 2) {
            throw new Exception("Wrong arguments count", 1);
        }

        return strtolower(trim($_SERVER['argv'][1]));
    }

    private static function readConfig(string $path): array
    {
        if (!file_exists($path)) {
            throw new Exception("Config file not found");
        }

        $config = parse_ini_file($path, true);

        if ($config === false) {
            throw new Exception("Wrong config file");
        }

        return $config;
    }
}

<?php

declare(strict_types=1);

namespace Naimushina\Chat;

use Exception;

class App
{
    /**
     * Запуск приложения
     * @throws Exception
     */
    public function run(): void
    {
        if (!extension_loaded('sockets')) {
            throw new Exception('Установите sockets ext.');
        }
        $type = $_SERVER['argv'][1] ?? null;
        $socket = new Socket();
        $configManager = new ConfigManager();

        $app = match ($type) {
            'client' => new Client($socket, $configManager),
            'server' => new Server($socket, $configManager),
            default => throw new Exception('Укажите тип приложения - client или server')
        };

        $app->run();
    }
}

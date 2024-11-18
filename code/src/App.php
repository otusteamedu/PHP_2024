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
            'client' => $this->createClientApp($socket, $configManager),
            'server' => $this->createServerApp($socket, $configManager),
            default => throw new Exception('Укажите тип приложения - client или server')
        };
        $app->run();
    }

    /**
     * @param $socket
     * @param $configManager
     * @return Client
     */
    public function createClientApp($socket, $configManager): Client
    {
        return new Client($socket, $configManager);
    }

    /**
     * @param Socket $socket
     * @param ConfigManager $configManager
     * @return Server
     */
    public function createServerApp(Socket $socket, ConfigManager $configManager): Server
    {
        return new Server($socket, $configManager);
    }
}

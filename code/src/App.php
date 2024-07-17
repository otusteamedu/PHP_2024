<?php

declare(strict_types=1);

namespace Naimushina\Chat;

use Exception;

class App
{
    public function __construct()
    {
    }

    /**
     * @throws Exception
     */
    public function run()
    {
        if (!extension_loaded('sockets')) {
            throw new Exception('Установите sockets ext.');
        }
        $type = $_SERVER['argv'][1] ?? null;
        $socket = new Socket();

        $app = match ($type) {
            'client' => new Client($socket),
            'server' => new Server($socket),
            'default' => throw new Exception('Укажите тип приложения - client или server')

        };
        $app->run();

    }
}

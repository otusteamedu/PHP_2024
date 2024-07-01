<?php

declare(strict_types=1);

namespace Rrazanov\Hw5;

use Exception;

class App
{
    /**
     * @throws Exception
     */
    public function run(): void
    {
        if ($_SERVER['argc'] == 1) {
            throw new Exception('Не передан аргумент запуска', 400);
        }
        $startArguments = $_SERVER['argv'][1];
        switch ($startArguments) {
            case 'server':
                $server = new Server();
                $server->startServer();
                break;
            case 'client':
                $client = new Client();
                $client->startClient();
                break;
            default:
                throw new Exception('Передан не корректный аргумент', 400);
        }
    }
}

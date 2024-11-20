<?php

declare(strict_types=1);

namespace Afilippov\Hw5;

use Exception;

class App
{
    /**
     * @throws Exception
     */
    public function run($arg): void
    {
        $config = new SocketConfig();

        switch ($arg) {
            case 'server':
                $server = new Server(new Socket($config));
                $server->start();
                break;
            case 'client':
                $client = new Client(new Socket($config));
                $client->start();
                break;
            default:
                throw new Exception("Неверный аргумент. Доступны `server` или `client`");
        }
    }
}

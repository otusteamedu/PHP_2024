<?php
declare(strict_types=1);

namespace App\Infrastructure\Controller;


use App\Application\ClientRun\ClientRun;
use App\Application\ServerRun\ServerRun;
use App\Infrastructure\Socket\Socket;
use App\Infrastructure\Config\Config;

class Controller
{
    const SERVER = 'server';
    const CLIENT = 'client';

    public function run(string $param)
    {
        $config = new Config();
        $socket = new Socket($config);
        if ($param === self::SERVER) {
            $server = new ServerRun($socket);
            $server->run();
        }
        if ($param === self::CLIENT) {
            $client = new ClientRun($socket);
            $client->run();
        }
    }

}
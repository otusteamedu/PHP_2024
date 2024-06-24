<?php

namespace App\Core;

use App\Sockets\ClientSocket;
use App\Sockets\ServerSocket;
use InvalidArgumentException;

class App
{
    public function run(): void
    {
        global $argv;

        if (!isset($argv[1])) {
            throw new InvalidArgumentException('No context specified. Use \'server\' or \'client\'!');
        }

        $context = $argv[1];

        switch ($context) {
            case 'server':
                $server = new ServerSocket();
                $server->listen();
            case 'client':
                $client = new ClientSocket();
                $client->listen();
            default:
                throw new InvalidArgumentException('Invalid mode specified. Use \'server\' or \'client\'!');
        }
    }
}

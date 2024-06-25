<?php

namespace App\Core;

use App\Sockets\ClientSocket;
use App\Sockets\ServerSocket;
use Generator;
use InvalidArgumentException;

class App
{
    public function run(): Generator
    {
        global $argv;

        if (!isset($argv[1])) {
            throw new InvalidArgumentException('No context specified. Use \'server\' or \'client\'!');
        }

        $context = $argv[1];

        if ($context === 'server') {
            $server = new ServerSocket();
            yield from $server->listen();
        } else if ($context === 'client') {
            $client = new ClientSocket();
            yield from $client->listen();
        } else {
            throw new InvalidArgumentException('Invalid context specified. Use \'server\' or \'client\'!');
        }
    }
}

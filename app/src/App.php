<?php

namespace Dsergei\Hw5;

use Dsergei\Hw5\Server;
use Dsergei\Hw5\Client;

class App
{
    /**
     * @throws \Exception
     */
    public function run(): void
    {
        global $argv;
        $type = $argv[1] ?? null;

        switch ($type) {
            case 'server':
                $server = new Server();
                $server->init();

                break;
            case 'client':
                $client = new Client();
                $client->init();

                break;
            default:
                throw new \Exception('Error arg. Access only "server" or "client" ' . PHP_EOL);
        }
    }
}

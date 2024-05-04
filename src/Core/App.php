<?php

declare(strict_types=1);

namespace Dsmolyaninov\Hw5\Core;

use Dsmolyaninov\Hw5\Network\Client;
use Dsmolyaninov\Hw5\Network\Server;
use Exception;

class App
{
    /**
     *
     * @param string[] $argv
     * @throws Exception
     */
    public function run(int $argc, array $argv): void
    {
        if ($argc > 1) {
            $command = $argv[1];

            switch ($command) {
                case 'server':
                    $server = new Server();
                    $server->run();
                    break;
                case 'client':
                    $client = new Client();
                    $client->run();
                    break;
                default:
                    throw new Exception("Неизвестная команда: $command");
            }
        } else {
            throw new Exception('Аргумент не был предоставлен.');
        }
    }
}

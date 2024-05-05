<?php

declare(strict_types=1);

namespace Dsmolyaninov\Hw5\Core;

use Dsmolyaninov\Hw5\Network\Client;
use Dsmolyaninov\Hw5\Network\Server;
use Exception;

class App
{
    /**
     * @param string[] $argv
     * @throws Exception
     */
    public function run(int $argc, array $argv): void
    {
        if ($argc <= 1) {
            throw new Exception('Аргумент не был предоставлен.');
        }

        $command = $argv[1];
        switch ($command) {
            case 'server':
                $this->handleServer();
                break;
            case 'client':
                $this->handleClient();
                break;
            default:
                throw new Exception("Неизвестная команда: $command");
        }
    }

    private function handleServer(): void
    {
        $server = new Server();
        foreach ($server->run() as $message) {
            echo $message;
        }
    }

    private function handleClient(): void
    {
        $client = new Client();
        foreach ($client->run() as $message) {
            echo $message;
        }
    }
}

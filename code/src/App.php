<?php

namespace Ekonyaeva\Otus;

use Exception;

class App
{
    /**
     * @throws Exception
     */
    public function run(): void
    {
        $command = $this->getCommand();
        switch ($command) {
            case 'server':
                $server = new SocketServer();
                $server->start();
                break;
            case 'client':
                $client = new SocketClient();
                $client->start();
                break;
            default:
                throw new Exception("Неверная команда: $command");
        }
    }

    private function getCommand()
    {
        global $argv;
        return isset($argv[1]) ? $argv[1] : null;
    }
}
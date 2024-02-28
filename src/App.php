<?php

namespace AKornienko\hw5;

use Exception;

class App
{
    /**
     * @throws \Exception
     */
    public function run(): \Generator
    {
        $path = dirname("../data") . getenv("SOCKETS_PATH");

        switch ($this->getAppType()) {
            case 'server':
                $server = new Server($path);
                return $server->run();
            case 'client':
                $client = new Client($path);
                return $client->run();
            default:
                throw new Exception("Wrong app type");
        }
    }

    private function getAppType(): string
    {
        return $_SERVER['argv'][1] ?? '';
    }
}

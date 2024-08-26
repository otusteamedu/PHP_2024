<?php

namespace VSukhov\Sockets;

use VSukhov\Sockets\Exception\AppException;
use VSukhov\Sockets\Socket\Client;
use VSukhov\Sockets\Socket\Server;

class App
{
    /**
     * @throws AppException
     */
    public function run(): void
    {
        $type = $_SERVER['argv'][1] ?? null;

        match ($type) {
            'server' => (new Server())->start(),
            'client' => (new Client())->start(),
            default => throw new AppException('Не верный тип'),
        };
    }
}
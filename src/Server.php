<?php

declare(strict_types=1);

namespace Pozys\ChatConsole;

class Server
{
    public function run(): void
    {
        $socket = new SocketManager();
        $socket->runServer();
        $socket->handleConnections();
    }
}

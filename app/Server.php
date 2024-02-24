<?php

declare(strict_types=1);

namespace Pozys\ChatConsole;

use Pozys\ChatConsole\Interfaces\Runnable;

class Server implements Runnable
{
    public function __construct(private SocketManager $socket)
    {
    }

    public function run(): void
    {
        $this->socket->dropSocket()->create()->bind()->listen()->handleConnections();
    }
}

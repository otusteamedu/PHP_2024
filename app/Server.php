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
        $this->handleConnections($this->runSocket());
    }

    private function runSocket(): SocketManager
    {
        return $this->socket->dropSocket()->create()->bind()->listen();
    }

    private function handleConnections(SocketManager $socketManager): void
    {
        set_time_limit(0);

        do {
            $socket = $socketManager->accept();

            do {
                $message = $socketManager->read($socket);

                if ($message === '') {
                    break;
                }

                $message = trim($message);

                echo "Received message: $message" . PHP_EOL;

                $size = strlen($message);
                $socketManager->write("Received {$size} bytes", $socket);
            } while (true);
        } while (true);

        $socketManager->kill();
    }
}

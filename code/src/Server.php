<?php

declare(strict_types=1);

namespace Rrazanov\Hw5;

use Exception;

class Server
{
    private Socket $socket;

    public function __construct()
    {
        $this->socket = new Socket();
    }

    /**
     * @throws Exception
     */
    public function startServer(): void
    {
        $this->socket->initSocket();
        echo "Готов к получению...\n";
        $this->socket->listingSocket();
        do {
            $acceptSocket = $this->socket->acceptSocket();
            do {
                $buf = $this->socket->readSocket($acceptSocket);
                if (!$buf) {
                    break;
                }

                if (!$buf = trim($buf)) {
                    continue;
                }

                if ($buf == 'quit' || $buf == '^C') {
                    break;
                }

                if ($buf == 'shutdown') {
                    socket_close($acceptSocket);
                    break 2;
                }

                $talkback = "PHP: отправлено '$buf'.\n";
                socket_write($acceptSocket, $talkback, strlen($talkback));
                echo "$buf\n";
            } while (true);
            socket_close($acceptSocket);
        } while (true);
    }
}

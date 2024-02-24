<?php

declare(strict_types=1);

namespace AShutov\Hw5;

use Exception;
class Server
{
    private Socket $socket;

    /**
     * @throws Exception
     */
    public function __construct(Socket $socket)
    {
        $this->socket = $socket;
        $this->socket->removeSockFile();
        $this->socket->bind();
        $this->socket->listen();
    }

    /**
     * @throws Exception
     */
    public function start(): void
    {
        $client = $this->socket->accept();

        while (true) {
            $message = $this->socket->read($client);

            if ($message) {
                echo $message . PHP_EOL;
            }

            if ($message === 'bye') {
                socket_close($client);
                break;
            }
        }

        $this->socket->removeSockFile();

        $this->socket->close();
    }
}
<?php

declare(strict_types=1);

namespace Afilippov\Hw5;

use Exception;

class Server
{
    private Socket $socket;

    private bool $isRunning = true;

    /**
     * @throws Exception
     */
    public function __construct(Socket $socket)
    {
        $this->socket = $socket;

        $this->socket->removeSockFile();

        $this->socket->create();

        $this->socket->bind();

        $this->socket->listen();
    }

    /**
     * @throws Exception
     */
    public function start(): void
    {
        $client = $this->socket->accept();

        while ($this->isRunning) {
            $message = $this->socket->read($client);

            if ($message === 'STOP') {
                socket_close($client);
                $this->isRunning = false;
            }

            if ($message) {
                echo $message . PHP_EOL;
            }
        }

        $this->socket->removeSockFile();

        $this->socket->close();
    }
}

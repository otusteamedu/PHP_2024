<?php

declare(strict_types=1);

namespace JuliaZhigareva\OtusComposerPackage;

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

        $this->socket->create();

        $this->socket->bind();

        $this->socket->listen();
    }

    /**
     * @throws Exception
     */
    public function start(): \Generator
    {
        $client = $this->socket->accept();

        while (true) {
            $message = $this->socket->read($client);

            if ($message) {
                yield $message;
            }

            if ($message === 'STOP') {
                socket_close($client);
                break;
            }
        }

        $this->socket->removeSockFile();

        $this->socket->close();
    }
}

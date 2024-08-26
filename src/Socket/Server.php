<?php

namespace VSukhov\Sockets\Socket;

use Generator;
use VSukhov\Sockets\Exception\AppException;

class Server
{
    private SocketManager $socket;

    public function __construct()
    {
        $this->socket = new SocketManager();
    }

    /**
     * @throws AppException
     */
    public function start(): void
    {
        $this->socket
            ->removeSockFile()
            ->create()
            ->bind()
            ->listen();

        echo 'Server start...' . PHP_EOL;

        $messages = $this->socketListener();

        foreach ($messages as $message) {
            echo $message;
        }
    }

    /**
     * @throws AppException
     */
    private function socketListener(): Generator
    {
        $client = $this->socket->accept();

        while (true) {
            $message = $this->socket->read($client);

            if ($message) {
                yield $message . PHP_EOL;
            } else {
                echo 'Server stop' . PHP_EOL;
                break;
            }
        }

        $this->socket
            ->removeSockFile()
            ->close();
    }
}
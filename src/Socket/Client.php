<?php

namespace VSukhov\Sockets\Socket;

use VSukhov\Sockets\Exception\AppException;

class Client
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
        $this->socket->create()->connect();

        while (true) {
            $message = readline('Введите сообщение: ');

            if (!$message) {
                $this->socket->close();
                break;
            } else {
                $response = $this->socket->write($message);
                echo $response . PHP_EOL;
            }
        }
    }
}
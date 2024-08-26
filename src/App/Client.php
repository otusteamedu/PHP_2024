<?php

namespace Komarov\Hw5\App;

use Komarov\Hw5\Exception\AppException;

class Client
{
    private Socket $socket;

    public function __construct()
    {
        $this->socket = new Socket();
    }

    /**
     * @throws AppException
     */
    public function start(): void
    {
        $this->socket
            ->create()
            ->connect();

        while (true) {
            $message = readline('Write a message: ');

            if (!$message) {
                break;
            }

            $response = $this->socket->write($message);

            echo $response . PHP_EOL;
        }

        $this->socket->close();
    }
}

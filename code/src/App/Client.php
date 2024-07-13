<?php

namespace src\App;

use src\Socket\Main;
use Exception;

class Client
{
    private Main $socket;

    /**
     * @throws Exception
     */
    public function __construct(Main $socket)
    {
        $this->socket = $socket;
        $this->socket->create();
        $this->socket->connect();
    }

    /**
     * @throws Exception
     */
    public function start(): void
    {
        while (true) {
            $message = readline('Enter message: ');
            $this->socket->write($message);

            if ($message === 'SD_SOCKET_CLOSE') {
                break;
            }
        }

        $this->socket->close();
    }
}

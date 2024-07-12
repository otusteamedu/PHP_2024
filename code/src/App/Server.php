<?php

namespace src\App;

use src\Socket\Main;
use Exception;

class Server
{
    private Main $socket;

    /**
     * @throws Exception
     */
    public function __construct(Main $socket)
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

        while (true) {
            $message = $this->socket->read($client);
            if ($message) {
                echo $message . PHP_EOL;
            }

            if ($message === 'SD_SOCKET_CLOSE') {
                socket_close($client);
                break;
            }
        }

        $this->socket->removeSockFile();
        $this->socket->close();
    }
}


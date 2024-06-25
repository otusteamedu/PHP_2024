<?php

namespace Evgenyart\UnixSocketChat;

class Server
{
    private $socket;

    public function __construct($socketPath)
    {
        $this->socket = new Socket($socketPath);
    }

    public function __destruct()
    {
        $this->socket->close();
    }

    public function start()
    {
        $this->socket->bind();
        $this->socket->listen();
        $connection = $this->socket->accept();

        while (1) {
            $resultRead = $this->socket->read($connection);
            print_r('Client sent message: ' . $resultRead . PHP_EOL);
            $this->socket->send('Received ' . strlen($resultRead) . ' bytes' . PHP_EOL, $connection);
        }
    }
}

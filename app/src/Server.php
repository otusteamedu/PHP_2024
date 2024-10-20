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
        if (!is_null($this->socket)) {
            $this->socket->close();
        }
    }

    public function start($test = false)
    {
        $connection = $this->connection();

        while (1) {
            $resultRead = $this->read($connection);
            print_r('Client sent message: ' . $resultRead . PHP_EOL);
            $this->socket->send('Received ' . strlen($resultRead) . ' bytes' . PHP_EOL, $connection);

            if ($test) {
                break;
            }
        }
    }

    public function read($connection)
    {
        return $this->socket->read($connection);
    }

    public function connection()
    {
        $this->socket->bind();
        $this->socket->listen();
        $connection = $this->socket->accept();

        return $connection;
    }
}

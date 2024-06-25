<?php

namespace Evgenyart\UnixSocketChat;

class Client
{
    private $socket;

    public function __construct($socketPath)
    {
        $this->socket = new Socket($socketPath);
    }

    public function start()
    {
        $this->socket->connect();
        while (1) {
            #$this->socket->setBlock();
            $message = readline('Enter a message (or `stop` for exit): ');

            if ($message == 'stop') {
                $this->socket->close();
                break;
            } else {
                $this->socket->send($message);
                $resultRead = $this->socket->read();
                print_r($resultRead);
            }
        }
    }
}

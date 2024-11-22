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
        $this->connection();
        print_r("Client starting");

        while (1) {
            $message = $this->sendReadline();
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

    public function connection()
    {
        return $this->socket->connect();
    }

    public function sendReadline($test = false)
    {
        if ($test) {
            return "stop";
        } else {
            print_r(PHP_EOL);
            return readline('Enter a message (or `stop` for exit): ');
        }
    }
}

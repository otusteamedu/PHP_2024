<?php

namespace IraYu\Service;

use IraYu\Service;

class Client
{
    public function __construct(protected $socketPath)
    {
    }

    public function start()
    {
        $socket = new Service\UnixSocket();
        $socket
            ->connect($this->socketPath)
        ;

        while (true) {
            echo 'New loop' . PHP_EOL;

            if ($response = $socket->read()) {
                echo 'Server: ' . $response . PHP_EOL;
            }

            $text = readline('Enter text or "break": ');
            if ($text === 'break') {
                break;
            }
            $socket->write($text);
        }

        $socket->close();
    }
}

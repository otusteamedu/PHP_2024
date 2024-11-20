<?php

namespace IraYu\Service;

use IraYu\Service;

class Client extends ChatElement
{
    public function start(): void
    {
        $socket = new Service\UnixSocket();
        $socket
            ->connect($this->socketPath)
        ;

        while (true) {
            $this->log('New loop');

            if ($response = $socket->read()) {
                $this->log('Server: ' . $response);
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

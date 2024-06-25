<?php

namespace App\Sockets;

use Generator;
use RuntimeException;

class ClientSocket extends Socket
{
    public function __construct()
    {
        parent::__construct();
        $this->bind($this->config->get('sockets', 'client'));
    }

    public function listen(): Generator
    {
        while (true) {
            yield 'Enter your message: ';

            $message = trim(fgets(STDIN));

            if ($message) {
                $serverSocket = $this->config->get('sockets', 'server');
                $this->message($message, $serverSocket);

                $buffer = '';
                $from = '';
                $bytesReceived = socket_recvfrom($this->socket, $buffer, 1024, 0, $from);

                if ($bytesReceived === false) {
                    throw new RuntimeException('Unable to receive data: ' . socket_strerror(socket_last_error()));
                }

                yield "Received response: $buffer.\n";
            }
        }
    }
}

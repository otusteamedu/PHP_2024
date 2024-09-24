<?php

namespace App\Sockets;

use Generator;
use RuntimeException;

class ServerSocket extends Socket
{
    public function __construct()
    {
        parent::__construct();

        $this->bind($this->config->get('server'));
    }

    public function listen(): Generator
    {
        while (true) {
            $buffer = '';
            $from = '';
            $bytesReceived = socket_recvfrom($this->socket, $buffer, 1024, 0, $from);

            if ($bytesReceived === false) {
                throw new RuntimeException('Unable to receive data: ' . socket_strerror(socket_last_error()));
            }

            yield "Received message: $buffer.\n";

            $this->message("Received $bytesReceived bytes.", $from);
        }
    }
}

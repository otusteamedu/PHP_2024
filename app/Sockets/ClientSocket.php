<?php

namespace App\Sockets;

use RuntimeException;

class ClientSocket extends Socket
{
    public function __construct()
    {
        parent::__construct();

        $this->bind($this->config->get('client'));
    }

    public function listen(): void
    {
        fwrite(STDOUT, 'Client is ready to send messages...' . PHP_EOL);

        while (true) {
            fwrite(STDOUT, 'Enter your message: ');

            $message = trim(fgets(STDIN));

            if ($message) {
                $serverSocket = $this->config->get('server');
                $this->message($message, $serverSocket);

                $buffer = '';
                $from = '';
                $bytesReceived = socket_recvfrom($this->socket, $buffer, 1024, 0, $from);

                if ($bytesReceived === false) {
                    throw new RuntimeException('Unable to receive data: ' . socket_strerror(socket_last_error()));
                }

                fwrite(STDOUT, "Received response: $buffer" . PHP_EOL);
            }
        }
    }
}

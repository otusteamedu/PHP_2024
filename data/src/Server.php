<?php

declare(strict_types=1);

namespace Apeskovatzkov\Hw5;

use Apeskovatzkov\Hw5\Contracts\RunnableInterface;
use Socket;
use Exception;

class Server implements RunnableInterface
{
    public function __construct(
        private ?Socket $socket
    )
    {
        $this->socket ??= $this->initSocket();
    }

    public function run(): void
    {
        echo 'Starting server...' . PHP_EOL;
        echo 'Init socket...' . PHP_EOL;

        while (true) {
            if (!socket_set_block($this->socket)) {
                throw new Exception('Unable to set block socket');
            }
            $buffer = '';
            echo 'Ready to read...' . PHP_EOL;

            $bytes_received = socket_recvfrom($this->socket, $buffer, 65536, 0, $from);
            if ($bytes_received == -1) {
                throw new Exception('An error occurred while reading from the socket');
            }
            echo "Получено сообщение: \"$buffer\"" . PHP_EOL;
        }
    }

    private function initSocket(): Socket
    {
        if (!$socket = socket_create(AF_UNIX, SOCK_STREAM, 0)) {
            throw new Exception('Unable to create socket: ' . socket_strerror(socket_last_error()));
        }

        if (socket_bind($socket, $_SERVER['DOCUMENT_ROOT'] . '/shared.sock')) {
            throw new Exception('Unable to bind socket: ' . socket_strerror(socket_last_error()));
        }

        return $socket;
    }
}

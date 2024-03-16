<?php

namespace RailMukhametshin\Hw\Socket;

use Exception;
use RailMukhametshin\Hw\Formatters\ConsoleOutputFormatter;
use Socket;

abstract class AbstractSocket
{
    protected string $socketPath;
    protected ConsoleOutputFormatter $formatter;

    protected Socket $sock;

    public function __construct(string $socketPath)
    {
        $this->formatter = new ConsoleOutputFormatter();
        $this->socketPath = $socketPath;
    }

    protected function createSock(): void
    {
        if (($sock = socket_create(AF_UNIX, SOCK_STREAM, 0)) === false) {
            throw new Exception("Socket creating error: " . socket_strerror(socket_last_error()));
        }

        $this->sock = $sock;
    }

    protected function closeSocket(Socket $socket): void
    {
        socket_close($socket);
    }

    protected function write(Socket $socket, string $text): void
    {
        $msg = sprintf('%s', $text);
        socket_write($socket, $msg);
    }

    protected function read(Socket $socket): string
    {
        return socket_read($socket, 2048);
    }
}

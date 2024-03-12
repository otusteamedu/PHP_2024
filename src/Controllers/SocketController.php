<?php

declare(strict_types=1);

namespace Src\Controllers;

use Socket;

class SocketController
{
    public function createSocket(): Socket|false
    {
        return socket_create(AF_UNIX, SOCK_STREAM, 0);
    }

    public function bindSocket(Socket $socket): bool
    {
        return socket_bind($socket, '/var/www/PHP_2024/socket/server.sock');
    }

    public function listenSocket(Socket $socket): bool
    {
        return socket_listen($socket, 5);
    }

    public function acceptSocket(Socket $socket): Socket|false
    {
        return socket_accept($socket);
    }

    public function writeSocket(Socket $socket, $msg): int|false
    {
        return socket_write($socket, $msg, strlen($msg));
    }

    public function readSocket(Socket $socket): Socket|false
    {
        return socket_read($socket, 2048, PHP_NORMAL_READ);
    }

    public function closeSocket(Socket $socket): void
    {
        socket_close($socket);
    }
}

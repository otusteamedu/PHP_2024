<?php

declare(strict_types=1);

namespace ABuynovskiy\Hw5;

use Socket;

class SocketHandler
{
    //путь к Файлу сокета
    const SOCKET_PATH = 'socket/server.sock';

    public function getSocketPath(): string
    {
        return self::SOCKET_PATH;
    }

    public function createSocket(): ?Socket
    {
        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if ($socket === false) {
            return null;
        }
        return $socket;
    }

    public function bindSocket(Socket $socket, string $socketPath): bool
    {
        return socket_bind($socket, $socketPath);
    }

    public function listenSocket(Socket $socket): bool
    {
        return socket_listen($socket);
    }

    public function acceptSocket(Socket $socket): ?Socket
    {
        $result = socket_accept($socket);
        if ($result === false) {
            return null;
        }
        return $result;
    }

    public function closeSocket(Socket $socket): void
    {
        socket_close($socket);
    }

    public function connectSocket(Socket $socket, string $socketPath): bool
    {
        return socket_connect($socket, $socketPath);
    }

    public function writeSocket(Socket $socket, string $input): int
    {
        $result = socket_write($socket, $input, strlen($input));
        if ($result === false) {
            return 0;
        }
        return $result;
    }

    public function readSocket(Socket $socket): ?string
    {
        $result = socket_read($socket, 1024);
        if ($result === false) {
            return null;
        }
        return $result;
    }
}

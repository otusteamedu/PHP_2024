<?php

declare(strict_types=1);

namespace App\Network;

use App\Exceptions\Network\SocketException;
use Socket;

class SocketManager
{
    public function create(): Socket
    {
        if (!extension_loaded('sockets')) {
            throw SocketException::extensionNotLoaded();
        }

        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);

        if (false === $socket) {
            throw SocketException::couldNotCreate();
        }

        return $socket;
    }

    public function bind(Socket $socket, string $path): void
    {
        if (false === socket_bind($socket, $path)) {
            throw SocketException::unprocessableFunction('socket_bind', $socket);
        }
    }

    public function listen(Socket $socket): void
    {
        if (false === socket_listen($socket)) {
            throw SocketException::unprocessableFunction('socket_listen', $socket);
        }
    }

    public function accept(Socket $socket): Socket
    {
        $connection = socket_accept($socket);

        if (false === $connection) {
            throw SocketException::connectionIsNotAcceptable($socket);
        }

        return $connection;
    }

    public function connect(Socket $socket, string $path): void
    {
        if (false === socket_connect($socket, $path)) {
            throw SocketException::unprocessableFunction('socket_connect', $socket);
        }
    }

    public function write(Socket $socket, string $input): void
    {
        if (false === socket_write($socket, $input, strlen($input))) {
            throw SocketException::unprocessableFunction('socket_write', $socket);
        }
    }

    public function read(Socket $socket, int $maxLength): string
    {
        $data = socket_read($socket, $maxLength);

        if (false === $data) {
            throw SocketException::unprocessableFunction('socket_read', $socket);
        }

        return $data;
    }

    public function close(Socket $socket): void
    {
        socket_close($socket);
    }

    public function delete(string $path): void
    {
        if (file_exists($path)) {
            unlink($path);
        }
    }
}
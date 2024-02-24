<?php

declare(strict_types=1);

namespace Sfadeev\ChatApp\Socket;

use RuntimeException;
use Socket;

class UnixSocket
{
    private Socket $_socket;

    /**
     * @throws RuntimeException
     */
    private function __construct(Socket $socket)
    {
        $this->_socket = $socket;
    }

    /**
     * @return UnixSocket
     *
     * @throws RuntimeException
     */
    public static function create(): UnixSocket
    {
        if (false === ($socket = socket_create(AF_UNIX, SOCK_STREAM, 0))) {
            throw new RuntimeException('socket_create()failed: reason: ' . socket_strerror(socket_last_error()));
        }

        return new UnixSocket($socket);
    }

    /**
     * @param string $path
     * @return void
     *
     * @throws RuntimeException
     */
    public function bind(string $path): void
    {
        $directory = dirname($path);

        if (!file_exists($directory)) {
            mkdir(directory: $directory, recursive: true);
        }

        if (false === socket_bind($this->_socket, $path)) {
            throw new RuntimeException('socket_bind(): failed: reason: ' . socket_strerror(socket_last_error()));
        }
    }

    /**
     * @return void
     *
     * @throws RuntimeException
     */
    public function listen(): void
    {
        if (false === socket_listen($this->_socket)) {
            throw new RuntimeException('socket_listen(): failed: reason: ' . socket_strerror(socket_last_error()));
        }
    }

    /**
     * @param string $path
     * @return void
     *
     * @throws RuntimeException
     */
    public function connect(string $path): void
    {
        if (false === socket_connect($this->_socket, $path)) {
            throw new RuntimeException('socket_connect(): failed: reason: ' . socket_strerror(socket_last_error()));
        }
    }

    /**
     * @return UnixSocket
     *
     * @throws RuntimeException
     */
    public function accept(): UnixSocket
    {
        $socket = socket_accept($this->_socket);

        if (false === $socket) {
            throw new RuntimeException('socket_accept(): failed: reason: ' . socket_strerror(socket_last_error()));
        }

        return new UnixSocket($socket);
    }

    /**
     * @param string $msg
     * @return void
     *
     * @throws RuntimeException
     */
    public function send(string $msg): void
    {
        if (false === socket_send($this->_socket, $msg, strlen($msg), 0)) {
            throw new RuntimeException('socket_send() failed: reason: ' . socket_strerror(socket_last_error()));
        }
    }

    /**
     * @param int $length
     * @return string|null
     *
     * @throws RuntimeException
     */
    public function read(int $length): ?string
    {
        $msg = null;

        if (false === socket_recv($this->_socket, $msg, $length, 0)) {
            throw new RuntimeException('socket_send() failed: reason: ' . socket_strerror(socket_last_error()));
        }

        return $msg;
    }

    /**
     * @return void
     */
    public function close(): void
    {
        socket_close($this->_socket);
    }
}

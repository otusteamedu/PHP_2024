<?php

namespace AKornienko\hw5;

use Exception;

class SocketWrapper
{
    const READ_LENGTH = 2048;
    private \Socket $socket;
    private string $path;

    /**
     * @throws Exception
     */
    public function __construct($path)
    {
        if (!extension_loaded('sockets')) {
            throw new Exception('The sockets extension is not loaded.');
        }

        $this->socket = $this->create();
        $this->path = $path;
    }

    /**
     * @throws Exception
     */
    private function create(): \Socket
    {
        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if (!$socket) {
            throw new Exception(socket_strerror(socket_last_error()));
        }
        return $socket;
    }

    /**
     * @throws Exception
     */
    public function bind(): void
    {
        unlink($this->path);
        if (socket_bind($this->socket, $this->path) === false) {
            throw new Exception(socket_strerror(socket_last_error($this->socket)));
        }
    }

    /**
     * @throws Exception
     */
    public function listen(): void
    {
        if (socket_listen($this->socket, 0) === false) {
            throw new Exception(socket_strerror(socket_last_error($this->socket)));
        }
    }

    /**
     * @throws Exception
     */
    public function connect(): bool
    {
        try {
            return socket_connect($this->socket, $this->path);
        } catch (Exception $exception) {
            throw new Exception(socket_strerror(socket_last_error($this->socket)));
        }
    }

    /**
     * @throws Exception
     */
    public function accept(): \Socket
    {
        $clientSocket = socket_accept($this->socket);
        if ($clientSocket === false) {
            throw new Exception(socket_strerror(socket_last_error($this->socket)));
        }
        return $clientSocket;
    }

    /**
     * @throws Exception
     */
    public function read(\Socket $socket): string
    {
        $message = socket_read($socket, SocketWrapper::READ_LENGTH);

        if ($message === false) {
            throw new Exception(socket_strerror(socket_last_error($this->socket)));
        }
        return $message;
    }

    /**
     * @throws Exception
     */
    public function write(\Socket $socket, string $msg): void
    {
        if (socket_write($socket, $msg, strlen($msg)) === false) {
            throw new Exception(socket_strerror(socket_last_error($this->socket)));
        }
    }

    /**
     * @return \Socket
     */
    public function getSocket(): \Socket
    {
        return $this->socket;
    }
}

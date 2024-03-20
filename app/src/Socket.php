<?php

declare(strict_types=1);

namespace Lrazumov\Hw5;

use Socket as UnixSocket;
use Exception;

class Socket
{
    private UnixSocket $unixSocket;
    private string $path;

    public function __construct(Config $config)
    {
        $this->path = $config->getSocketPath();
    }

    public function create(): void
    {
        if (($unix_socket = socket_create(AF_UNIX, SOCK_STREAM, 0)) === false) {
            throw new Exception('Socket create error');
        }
        $this->unixSocket = $unix_socket;
    }

    public function bind(): void
    {
        if (socket_bind($this->unixSocket, $this->path) === false) {
            throw new Exception('Socket bind error');
        }
    }

    public function listen(): void
    {
        if (socket_listen($this->unixSocket) === false) {
            throw new Exception('Socket listen error');
        }
    }

    public function close(?UnixSocket $connection = null): void
    {
        $connection = $connection ?? $this->unixSocket;
        socket_close($connection);
    }

    public function acceptConnection(): UnixSocket
    {
        if (($connection = socket_accept($this->unixSocket)) === false) {
            throw new Exception('Socket accept error');
        }
        return $connection;
    }

    public function sendMessage(
        string $message,
        ?UnixSocket $connection = null
    ): void {
        $connection = $connection ?? $this->unixSocket;
        if (socket_write($connection, $message, strlen($message)) === false) {
            throw new Exception('Socket send message error');
        }
    }

    public function readMessage(?UnixSocket $connection = null): string
    {
        $connection = $connection ?? $this->unixSocket;
        if (($message = socket_read($connection, 2048)) === false) {
            throw new Exception('Socket read message error');
        }
        return $message;
    }

    public function connect(): void
    {
        if (!file_exists($this->path)) {
            throw new Exception("Server not found at {$this->path}");
        }
        elseif (socket_connect($this->unixSocket, $this->path) === false) {
            throw new Exception('Socket connect error');
        }
    }

    public function removeFile(): void
    {
        if (file_exists($this->path) && !unlink($this->path)) {
            throw new Exception("Could not to remove socket file {$this->path}");
        }
    }
}

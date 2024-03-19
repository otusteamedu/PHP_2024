<?php

declare(strict_types=1);

namespace Lrazumov\Hw5;

use Socket as UnixSocket;
use Exception;

class Socket
{
    // private Config $config;
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
        echo 'Socket create' . PHP_EOL;
    }

    public function bind(): void
    {
        if (socket_bind($this->unixSocket, $this->path) === false) {
            throw new Exception('Socket bind error');
        }
        echo 'Socket bind' . PHP_EOL;
    }

    public function listen(): void
    {
        if (socket_listen($this->unixSocket) === false) {
            throw new Exception('Socket listen error');
        }
        echo 'Socket listen' . PHP_EOL;
    }

    public function close(?UnixSocket $connection = null): void
    {
        $connection = $connection ?? $this->unixSocket;
        socket_close($connection);
        echo 'Socket close' . PHP_EOL;
    }

    public function acceptConnection(): UnixSocket
    {
        if (($connection = socket_accept($this->unixSocket)) === false) {
            throw new Exception('Socket accept error');
        }
        echo 'Socket accept' . PHP_EOL;
        return $connection;
    }

    public function sendMessage(
        string $message,
        ?UnixSocket $connection = null
    ): void
    {
        $connection = $connection ?? $this->unixSocket;
        if (socket_write($connection, $message, strlen($message)) === false) {
            throw new Exception('Socket send message error');
        }
        echo 'Socket send message' . PHP_EOL;
    }

    public function readMessage(?UnixSocket $connection = null): string
    {
        $connection = $connection ?? $this->unixSocket;
        if (($message = socket_read($connection, 2048)) === false) {
            throw new Exception('Socket read message error');
        }
        echo 'Socket read message' . PHP_EOL;
        return $message;
    }

    public function connect(): void
    {
        if (socket_connect($this->unixSocket, $this->path) === false) {
            throw new Exception('Socket connect error');
        }
        echo 'Socket connect OK' . PHP_EOL;
    }

    public function removeFile(): void
    {
        if (file_exists($this->path) && !unlink($this->path)) {
            throw new Exception("Could not to remove socket file {$this->path}");
        }
    }
}

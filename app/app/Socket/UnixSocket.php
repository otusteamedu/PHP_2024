<?php

declare(strict_types=1);

namespace Rmulyukov\Hw5\Socket;

use Exception;
use Socket;

final class UnixSocket
{
    private Socket $socket;

    /**
     * @throws Exception
     */
    public function __construct(
        private readonly string $path
    ) {
    }

    /**
     * @throws Exception
     */
    public function create(): void
    {
        if (!($socket = socket_create(AF_UNIX, SOCK_STREAM, 0))) {
            throw new Exception('Unable to create AF_UNIX socket');
        }
        $this->socket = $socket;
    }

    /**
     * @throws Exception
     */
    public function bind(): void
    {
        if (!socket_bind($this->socket, $this->path)) {
            throw new Exception("Unable to bind to $this->path");
        }
    }

    /**
     * @throws Exception
     */
    public function listen(): void
    {
        if (!socket_listen($this->socket, 3)) {
            throw new Exception("Unable to listen to $this->path");
        }
    }

    /**
     * @throws Exception
     */
    public function connect(): void
    {
        if (!socket_connect($this->socket, $this->path)) {
            throw new Exception("Unable to bind to $this->path");
        }
    }

    /**
     * @throws Exception
     */
    public function getConnection(): Socket
    {
        if (!($connection = socket_accept($this->socket))) {
            throw new Exception("Unable to read");
        }
        return $connection;
    }

    public function closeConnection(Socket $connection): void
    {
        socket_close($connection);
    }

    /**
     * @throws Exception
     */
    public function getMessage(?Socket $connection = null): string
    {
        $connection = $connection ?? $this->socket;
        $message = socket_read($connection, 2048);
        if ($message === false) {
            throw new Exception("Unable to read");
        }
        return $message;
    }

    /**
     * @throws Exception
     */
    public function sendMessage(string $message, ?Socket $connection = null): void
    {
        $connection = $connection ?? $this->socket;
        if (socket_write($connection, $message) === false) {
            throw new Exception('Unable to write');
        }
    }

    /**
     * @throws Exception
     */
    public function removeFile(): void
    {
        if (file_exists($this->path) && !unlink($this->path)) {
            throw new Exception("Could not to remove socket file {$this->path}");
        }
    }
}

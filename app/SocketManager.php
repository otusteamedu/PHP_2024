<?php

declare(strict_types=1);

namespace Pozys\ChatConsole;

use Exception;
use Socket;

class SocketManager
{
    private Socket $socket;

    public function __construct(private string $socketPath)
    {
        if (!$socketPath) {
            throw new Exception("Socket path is empty");
        }

        $this->socketPath = dirname(__DIR__) . $socketPath;
    }

    public function write(string $message, ?Socket $socket = null): void
    {
        $socket ??= $this->socket;
        $result = socket_write($socket, $message, strlen($message));

        if ($result === false) {
            throw new Exception("socket_read() failed: reason: " . socket_strerror(socket_last_error($this->socket)));
        }
    }

    public function read(?Socket $socket = null): string
    {
        $socket ??= $this->socket;
        $message = socket_read($socket, 2048);
        if ($message === false) {
            throw new Exception("socket_read() failed: reason: " . socket_strerror(socket_last_error($socket)));
        }

        return $message;
    }

    public function close(): self
    {
        socket_close($this->socket);

        return $this;
    }

    public function kill(): void
    {
        $this->close()->dropSocket();
    }

    public function dropSocket(): self
    {
        if (file_exists($this->socketPath)) {
            unlink($this->socketPath);
        }

        return $this;
    }

    public function handleConnections(): void
    {
        set_time_limit(0);

        do {
            $socket = socket_accept($this->socket);
            if ($socket === false) {
                throw new Exception("socket_accept() failed: reason: " . socket_strerror(socket_last_error($this->socket)));
            }

            do {
                $message = $this->read($socket);

                if ($message === '') {
                    break;
                }

                $message = trim($message);

                echo "Received message: $message" . PHP_EOL;

                $size = strlen($message);
                $talkback = "Received {$size} bytes";
                $this->write($talkback, $socket);
            } while (true);
        } while (true);

        $this->kill();
    }

    public function create(): self
    {
        if (!extension_loaded('sockets')) {
            throw new Exception('The sockets extension is not loaded.');
        }

        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);

        if ($this->socket === false) {
            throw new Exception("socket_create() failed: reason: " . socket_strerror(socket_last_error()));
        }

        return $this;
    }

    public function bind(): self
    {
        if (socket_bind($this->socket, $this->socketPath) === false) {
            throw new Exception("socket_bind() failed: reason: " . socket_strerror(socket_last_error($this->socket)));
        }

        return $this;
    }

    public function connect(): self
    {
        $result = socket_connect($this->socket, $this->socketPath, 0);
        if ($result === false) {
            throw new Exception("socket_connect() failed.\nReason: ($result) " . socket_strerror(socket_last_error($this->socket)));
        }

        return $this;
    }

    public function listen(): self
    {
        if (socket_listen($this->socket, 5) === false) {
            throw new Exception("socket_listen() failed: reason: " . socket_strerror(socket_last_error($this->socket)));
        }

        return $this;
    }
}

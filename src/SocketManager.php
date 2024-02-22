<?php

declare(strict_types=1);

namespace Pozys\ChatConsole;

use Exception;
use Socket;

class SocketManager
{
    private Socket $socket;
    private string $socketPath;

    public function __construct()
    {
        $socketPath = App::getConfig('socket.path');

        if (!$socketPath) {
            throw new Exception("Socket path is empty");
        }

        $this->socketPath = dirname(__DIR__) . $socketPath;
    }

    public function runServer(): self
    {
        if (file_exists($this->socketPath)) {
            unlink($this->socketPath);
        }

        $this->create()->bind()->listen();

        return $this;
    }

    public function runClient(): self
    {
        $this->create()->connect();

        return $this;
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

    public function kill(): void
    {
        socket_close($this->socket);
        unlink($this->socketPath);
    }

    public function handleConnections(): void
    {
        set_time_limit(0);

        $stopWord = App::getConfig('socket.stop_word');

        do {
            $socket = socket_accept($this->socket);
            if ($socket === false) {
                throw new Exception("socket_accept() failed: reason: " . socket_strerror(socket_last_error($this->socket)));
            }

            do {
                $message = $this->read($socket);
                $trimmed = trim($message);

                if ($message === '' || $trimmed === $stopWord) {
                    break;
                }

                echo "Received message: $trimmed" . PHP_EOL;

                $size = strlen($trimmed);
                $talkback = "Received {$size} bytes";
                $this->write($talkback, $socket);
            } while (true);

            socket_close($socket);
        } while (true);

        $this->kill();
    }

    private function create(): self
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

    private function bind(): self
    {
        if (socket_bind($this->socket, $this->socketPath) === false) {
            throw new Exception("socket_bind() failed: reason: " . socket_strerror(socket_last_error($this->socket)));
        }

        return $this;
    }

    private function connect(): self
    {
        $result = socket_connect($this->socket, $this->socketPath, 0);
        if ($result === false) {
            throw new Exception("socket_connect() failed.\nReason: ($result) " . socket_strerror(socket_last_error($this->socket)));
        }

        return $this;
    }

    private function listen(): self
    {
        if (socket_listen($this->socket, 5) === false) {
            throw new Exception("socket_listen() failed: reason: " . socket_strerror(socket_last_error($this->socket)));
        }

        return $this;
    }
}

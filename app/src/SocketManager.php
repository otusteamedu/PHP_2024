<?php

declare(strict_types=1);

namespace AlexanderPogorelov\Chat;

class SocketManager
{
    private Config $config;
    private string $socketFilename;
    private ?\Socket $socket = null;

    public function __construct()
    {
        $this->config = new Config();
        $this->socketFilename = realpath(__DIR__ . $this->config->getSocketPath());
    }

    /**
     * @throws \Exception
     */
    public function create(bool $clear = false): void
    {
        if ($clear) {
            $this->deleteSocketFile();
        }

        $socket = \socket_create(AF_UNIX, SOCK_STREAM, 0);

        if (!$socket instanceof \Socket) {
            throw new \Exception('Unable to create socket.');
        }

        $this->socket = $socket;
    }

    /**
     * @throws \Exception
     */
    public function bind(): void
    {
        if (false === \socket_bind($this->socket, $this->socketFilename)) {
            throw new \Exception('Unable to bind socket to file.');
        }
    }

    /**
     * @throws \Exception
     */
    public function listen(): void
    {
        if (false === \socket_listen($this->socket)) {
            throw new \Exception('Unable to listen on socket.');
        }
    }

    /**
     * @throws \Exception
     */
    public function connect(): void
    {
        if (false === \socket_connect($this->socket, $this->socketFilename)) {
            throw new \Exception('Unable to connect to socket.');
        }
    }

    /**
     * @throws \Exception
     */
    public function accept(): \Socket
    {
        $connection = \socket_accept($this->socket);

        if (!$connection instanceof \Socket) {
            throw new \Exception('Unable to accept socket.');
        }

        return $connection;
    }

    /**
     * @throws \Exception
     */
    public function read(\Socket $connection = null): string
    {
        $message = \socket_read($connection ?? $this->socket, $this->config->getMaxMessageLength());

        if (false === $message) {
            throw new \Exception('Unable to read message from socket.');
        }

        return $message;
    }

    /**
     * @throws \Exception
     */
    public function write(string $message, \Socket $connection = null): void
    {
        if (false === socket_write($connection ?? $this->socket, $message, strlen($message))) {
            throw new \Exception('Unable to write to socket.');
        }
    }

    public function close(\Socket $connection = null): void
    {
        \socket_close($connection ?? $this->socket);
    }

    public function getSocket(): \Socket
    {
        return $this->socket;
    }

    public function getSocketFilename(): string
    {
        return $this->socketFilename;
    }

    private function deleteSocketFile(): void
    {
        if (file_exists($this->socketFilename)) {
            unlink($this->socketFilename);
        }
    }
}

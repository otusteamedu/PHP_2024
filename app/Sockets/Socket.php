<?php

namespace App\Sockets;

use Generator;
use RuntimeException;
use App\Config\SocketConfig;

abstract class Socket
{
    protected \Socket|false $socket;
    protected SocketConfig $config;

    public function __construct()
    {
        if (!extension_loaded('sockets')) {
            throw new RuntimeException('The sockets extension is not loaded.');
        }

        $this->init();
        $this->create();
    }

    protected function init(): void
    {
        $this->config = new SocketConfig();
    }

    protected function create(): void
    {
        $this->socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);

        if (!$this->socket) {
            throw new RuntimeException('Unable to create AF_UNIX socket: ' . socket_strerror(socket_last_error()));
        }
    }

    protected function bind(string $socketPath): void
    {
        if (file_exists($socketPath)) {
            unlink($socketPath);
        }

        if (!socket_bind($this->socket, $socketPath)) {
            throw new RuntimeException("Unable to bind to $socketPath: " . socket_strerror(socket_last_error()));
        }
    }

    protected function message(string $message, string $targetPath): int
    {
        $length = strlen($message);

        $response = socket_sendto($this->socket, $message, $length, 0, $targetPath);

        if ($response === false) {
            throw new RuntimeException('Unable to send message: ' . socket_strerror(socket_last_error()));
        }

        return $response;
    }

    abstract public function listen(): Generator;
}

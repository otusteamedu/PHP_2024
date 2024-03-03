<?php

declare(strict_types=1);

namespace Alogachev\Homework;

use Alogachev\Homework\Exception\ExtensionNotFoundException;
use Alogachev\Homework\Exception\SocketAcceptFailedException;
use Alogachev\Homework\Exception\SocketBindFailedException;
use Alogachev\Homework\Exception\SocketConnectFailedException;
use Alogachev\Homework\Exception\SocketCreateFailedException;
use Alogachev\Homework\Exception\SocketListenFailedException;
use Alogachev\Homework\Exception\SocketReadFailedException;
use Alogachev\Homework\Exception\SocketWriteFailedException;
use Socket;

class SocketManager
{
    private Socket $socket;
    public function __construct(
        private readonly string $socketPath,
    ) {

    }

    public function create(): void
    {
        $extName = 'sockets';
        if (!extension_loaded($extName)) {
            throw new ExtensionNotFoundException($extName);
        }

        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if (!$socket) {
            throw new SocketCreateFailedException(socket_strerror(socket_last_error()));
        }

        $this->socket = $socket;
    }

    public function connect(): void
    {
        $result = socket_connect($this->socket, $this->socketPath, 0);
        if (!$result) {
            throw new SocketConnectFailedException(socket_strerror(socket_last_error($this->socket)));
        }
    }

    public function bind(): void
    {
        $bind = socket_bind($this->socket, $this->socketPath);
        if (!$bind) {
            throw new SocketBindFailedException(socket_strerror(socket_last_error($this->socket)));
        }
    }

    public function listen(): void
    {
        $listen = socket_listen($this->socket, 5);
        if (!$listen) {
            throw new SocketListenFailedException(socket_strerror(socket_last_error($this->socket)));
        }
    }

    public function accept(): Socket
    {
        $socket = socket_accept($this->socket);
        if ($socket === false) {
            throw new SocketAcceptFailedException(socket_strerror(socket_last_error($this->socket)));
        }

        return $socket;
    }

    public function read(?Socket $socket = null): string
    {
        $socket ??= $this->socket;
        $message = socket_read($socket, 2048);
        if ($message === false) {
            throw new SocketReadFailedException(socket_strerror(socket_last_error($socket)));
        }

        return $message;
    }

    public function write(string $message, ?Socket $socket = null): void
    {
        $socket ??= $this->socket;
        $result = socket_write($socket, $message, strlen($message));

        if ($result === false) {
            throw new SocketWriteFailedException(socket_strerror(socket_last_error($socket)));
        }
    }

    public function drop(): void
    {
        if (file_exists($this->socketPath)) {
            unlink($this->socketPath);
        }
    }

    public function close(): void
    {
        socket_close($this->socket);
    }

    public function kill(): void
    {
        $this->close();
        $this->drop();
    }

    public function createAndConnect(): void
    {
        $this->create();
        $this->connect();
    }

    public function recreateBindAndListen(): void
    {
        $this->drop();
        $this->create();
        $this->bind();
        $this->listen();
    }
}

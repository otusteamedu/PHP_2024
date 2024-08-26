<?php

namespace VSukhov\Sockets\Socket;

use Socket;
use VSukhov\Sockets\Exception\AppException;

class SocketManager
{
    private Socket $socket;
    private Config $config;

    public function __construct()
    {
        $this->config = Config::getInstance();
    }

    /**
     * @throws AppException
     */
    public function create(): self
    {
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);

        if (!$this->socket) {
            throw new AppException('Socket create error');
        }

        return $this;
    }

    /**
     * @throws AppException
     */
    public function bind(): self
    {
        $socketBind = socket_bind($this->socket, $this->config->getSocketPath());

        if (false === $socketBind) {
            throw new AppException('Socket bind error');
        }

        return $this;
    }

    /**
     * @throws AppException
     */
    public function connect(): self
    {
        $socketConnect = socket_connect($this->socket, $this->config->getSocketPath());

        if (!$socketConnect) {
            throw new AppException('Socket connect error');
        }

        return $this;
    }

    /**
     * @throws AppException
     */
    public function listen(): self
    {
        $socketListen = socket_listen($this->socket);

        if (!$socketListen) {
            throw new AppException('Socket::lister() error');
        }

        return $this;
    }

    /**
     * @throws AppException
     */
    public function accept(): Socket
    {
        $socketAccept = socket_accept($this->socket);

        if (!$socketAccept) {
            throw new AppException('Socket::accept() error');
        }

        $this->socket = $socketAccept;

        return $socketAccept;
    }

    /**
     * @throws AppException
     */
    public function write(string $message): string
    {
        $socketWrite = socket_write($this->socket, $message, strlen($message));

        if (!$socketWrite) {
            throw new AppException('Socket::write() error');
        }

        return "Получено $socketWrite байт";
    }

    public function read(Socket $socket): string|bool
    {
        return socket_read($socket, 2048);
    }

    public function close(): void
    {
        socket_close($this->socket);
    }

    public function removeSockFile(): self
    {
        if (file_exists($this->config->getSocketPath())) {
            unlink($this->config->getSocketPath());
        }

        return $this;
    }

    public function getSocket(): Socket
    {
        return $this->socket;
    }
}
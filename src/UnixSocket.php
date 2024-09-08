<?php

namespace PenguinAstronaut\App;

use PenguinAstronaut\App\Exceptions\SocketAcceptException;
use PenguinAstronaut\App\Exceptions\SocketBindException;
use PenguinAstronaut\App\Exceptions\SocketConnectException;
use PenguinAstronaut\App\Exceptions\SocketCreateException;
use PenguinAstronaut\App\Exceptions\SocketListenException;
use Socket;

class UnixSocket
{
    private Socket $socket;

    public function __construct(private ?string $fileName = null)
    {
    }

    public function setSocket(Socket $socket): self
    {
        $this->socket = $socket;

        return $this;
    }

    /**
     * @throws SocketCreateException
     */
    public function create(): self
    {
        if (!$this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0)) {
            throw new SocketCreateException('Cannot create socket: ' . $this->getLastError());
        }

        return $this;
    }

    /**
     * @throws SocketAcceptException
     */
    public function accept(): self
    {
        if (!$acceptSocket = socket_accept($this->socket)) {
            throw new SocketAcceptException('Cannot accept socket: ' . $this->getLastError());
        }

        return (new self())->setSocket($acceptSocket);
    }

    /**
     * @throws SocketConnectException
     */
    public function connect(): self
    {
        if (!socket_connect($this->socket, $this->fileName)) {
            throw new SocketConnectException('Cannot connect to socket: ' . $this->getLastError());
        }

        return $this;
    }

    /**
     * @throws SocketBindException
     */
    public function bind()
    {
        if (!socket_bind($this->socket, $this->fileName)) {
            throw new SocketBindException('Cannot bind socket: ' . $this->getLastError());
        }

        return $this;
    }

    /**
     * @throws SocketListenException
     */
    public function listen(): self
    {
        if (!socket_listen($this->socket)) {
            throw new SocketListenException('Socket listen failed: ' . $this->getLastError());
        }

        return $this;
    }
    public function write(string $message): self
    {
        socket_write($this->socket, $message, strlen($message));

        return $this;
    }

    public function read(int $length = 2048): string
    {
        return socket_read($this->socket, $length);
    }

    public function close(): void
    {
        socket_close($this->socket);
    }

    public function clearFile(): self
    {
        file_exists($this->fileName) && unlink($this->fileName);

        return $this;
    }

    public function getLastError(): string
    {
        return socket_strerror(socket_last_error($this->socket));
    }
}

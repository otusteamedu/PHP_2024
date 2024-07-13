<?php

namespace src\Socket;

use Exception;
use Socket;

class Main
{
    private Socket $socket;

    public function __construct(private readonly Settings $config)
    {
    }

    /**
     * @throws Exception
     */
    public function create(): void
    {
        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if (false === $socket) {
            throw new Exception('Socket create error');
        }

        $this->socket = $socket;
    }

    /**
     * @throws Exception
     */
    public function bind(): void
    {
        $socketBind = socket_bind($this->socket, $this->config->socketFilePath);
        if (false === $socketBind) {
            throw new Exception('Socket bind error');
        }
    }

    /**
     * @throws Exception
     */
    public function connect(): void
    {
        $socketConnect = socket_connect($this->socket, $this->config->socketFilePath);
        if (false === $socketConnect) {
            throw new Exception('Socket connect error');
        }
    }

    /**
     * @throws Exception
     */
    public function listen(): void
    {
        $socketListen = socket_listen($this->socket);
        if (false === $socketListen) {
            throw new Exception('Socket lister error');
        }
    }

    /**
     * @throws Exception
     */
    public function accept(): Socket
    {
        $socketAccept = socket_accept($this->socket);
        if (false === $socketAccept) {
            throw new Exception('Socket accept error');
        }

        return $socketAccept;
    }

    /**
     * @throws Exception
     */
    public function write(string $message): void
    {
        $socketWrite = socket_write($this->socket, $message, strlen($message));
        if (false === $socketWrite) {
            throw new Exception('Socket write error');
        }
    }

    /**
     * @throws Exception
     */
    public function read(Socket $socket): string
    {
        $message = socket_read($socket, $this->config->socketMessageMaxLength);
        if (false === $message) {
            throw new Exception('Socket read message');
        }

        return $message;
    }

    public function close(): void
    {
        socket_close($this->socket);
    }

    public function removeSockFile(): void
    {
        if (file_exists($this->config->socketFilePath)) {
            unlink($this->config->socketFilePath);
        }
    }
}

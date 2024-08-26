<?php

namespace Komarov\Hw5\App;

use Komarov\Hw5\Exception\AppException;
use Socket as SocketResource;

class Socket
{
    private SocketResource $socket;

    /**
     * @throws AppException
     */
    public function create(): self
    {
        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);

        if (!$socket) {
            throw new AppException('Socket create error');
        }

        $this->socket = $socket;

        return $this;
    }

    /**
     * @throws AppException
     */
    public function bind(): self
    {
        $socketBind = socket_bind($this->socket, Settings::getInstance()->getValue('socket_path'));

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
        $socketConnect = socket_connect($this->socket, Settings::getInstance()->getValue('socket_path'));

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
            throw new AppException('Socket lister error');
        }

        return $this;
    }

    /**
     * @throws AppException
     */
    public function accept(): SocketResource
    {
        $socketAccept = socket_accept($this->socket);

        if (!$socketAccept) {
            throw new AppException('Socket accept error');
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
            throw new AppException('Socket write error');
        }

        return "Received $socketWrite bytes";
    }

    public function read(SocketResource $socket): string | bool
    {
        return socket_read($socket, 2048);
    }

    public function close(): void
    {
        socket_close($this->socket);
    }

    public function removeSockFile(): self
    {
        if (file_exists(Settings::getInstance()->getValue('socket_path'))) {
            unlink(Settings::getInstance()->getValue('socket_path'));
        }

        return $this;
    }

    public function getSocket(): SocketResource
    {
        return $this->socket;
    }
}

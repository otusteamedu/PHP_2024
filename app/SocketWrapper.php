<?php
declare(strict_types=1);

namespace Hukimato\SocketChat;

use Exception;
use Socket;

class SocketWrapper
{
    private ?Socket $socket;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if (!$this->socket) {
            throw new Exception("Не удалось создать сокет");
        }
    }

    /**
     * @throws Exception
     */
    public function bind(string $fileName): void
    {
        if (!socket_bind($this->socket, $fileName)) {
            throw new Exception("Не удалось забиндить сокет");
        }
    }

    /**
     * @throws Exception
     */
    public function listen(): void
    {
        if (!socket_listen($this->socket)) {
            throw new Exception("Не удалось подключиться к сокету");
        }
    }

    /**
     * @throws Exception
     */
    public function accept(): void
    {
        $this->socket = socket_accept($this->socket);
        if (!$this->socket) {
            throw new Exception("Не удалось получить данные из сокета");
        }
    }

    public function read(): false|string
    {
        return socket_read($this->socket, 1024);
    }

    public function write(string $message): void
    {
        if (!socket_write($this->socket, $message)) {
            echo socket_strerror(socket_last_error($this->socket));
        }
    }

    public function close(): void
    {
        socket_close($this->socket);
    }

    public function connect(string $socketName)
    {
        $connect = socket_connect($this->socket, $socketName);
        if (!$connect) {
            throw new Exception("Не удалось подключиться к сокету");
        }
    }
}

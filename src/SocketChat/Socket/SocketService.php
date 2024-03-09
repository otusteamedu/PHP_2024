<?php

declare(strict_types=1);

namespace AlexanderGladkov\SocketChat\Socket;

use Socket;
use RuntimeException;

class SocketService
{
    public function create(): Socket
    {
        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if ($socket === false) {
            throw new RuntimeException('Не удалось создать сокет');
        }

        return $socket;
    }

    public function bind(Socket $socket, string $socketFilename): void
    {
        if (!socket_bind($socket, $socketFilename)) {
            throw new RuntimeException('Не удалось привязать сокет к файлу');
        }
    }

    public function listen(Socket $socket): void
    {
        if (!socket_listen($socket)) {
            throw new RuntimeException('Не удалось начать прослушивать входящие соединения на сокете');
        }
    }

    public function acceptConnection(Socket $socket): Socket
    {
        $socket = socket_accept($socket);
        if ($socket === false) {
            throw new RuntimeException('Не удалось принять соединение');
        }

        return $socket;
    }

    public function connect(Socket $socket, string $socketFilename): void
    {
        if (!socket_connect($socket, $socketFilename)) {
            throw new RuntimeException('Не удалось соединиться с сокетом');
        }
    }

    public function write(Socket $socket, string $message): void
    {
        if (socket_write($socket, $message, strlen($message)) === false) {
            throw new RuntimeException('Не удалось записать данные в сокет');
        }
    }

    public function read(Socket $socket, int $messageMaxLength): string
    {
        $message = socket_read($socket, $messageMaxLength);
        if ($message === false) {
            throw new RuntimeException('Не удалось прочитать данные из сокета');
        }

        return $message;
    }

    public function close(Socket $socket): void
    {
        socket_close($socket);
    }
}

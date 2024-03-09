<?php

declare(strict_types=1);

namespace Main;

class SocketClient
{
    public $socket = false;

    public $socketFile = __DIR__ . "/my_unix_socket.sock";

    public function __construct()
    {
        $this->socketCreate();
        $this->socketConnect();
    }

    public function socketCreate(): bool
    {
        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);

        if ($socket === false) {
            throw new \Exception("Не удалось выполнить socket_create(), причина: " . socket_strerror(socket_last_error()));
        }

        $this->socket = $socket;

        return true;
    }


    public function socketConnect(): bool
    {
        if (socket_connect($this->socket, $this->socketFile) === false) {
            throw new \Exception("Не удалось подключится к серверу, причина: " . socket_strerror(socket_last_error()));
        }

        return true;
    }

    public function closeSocket(): void
    {
        socket_close($this->socket);
    }

    public function sendMessage($message): void
    {
        if (socket_write($this->socket, $message, strlen($message)) === false) {
            throw new \Exception(socket_strerror(socket_last_error()));
        }

        $this->showResponse();
    }

    public function showResponse(): void
    {
        $out = socket_read($this->socket, 2048);
        fputs(STDIN, $out);
    }

}

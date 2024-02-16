<?php

namespace Ahor\Hw5;

use Socket;

abstract class Chat
{
    private Socket $socket;

    public function __construct(private readonly Config $config)
    {
    }

    public function create($clear = false): void
    {
        if ($clear && file_exists($this->config->socketFile)) {
            unlink($this->config->socketFile);
        }

        $result = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if ($result === false) {
            throw new \DomainException("Ошибка создания сокета");
        }

        $this->socket = $result;
    }

    public function listen(): void
    {
        socket_listen($this->socket);
    }

    public function bind(): void
    {
        socket_bind($this->socket, $this->config->socketFile);
    }

    public function close(): void
    {
        socket_close($this->socket);
    }

    public function accept()
    {
        return socket_accept($this->socket);
    }

    public function receive($socket): string
    {
        socket_recv($socket, $message, $this->config->maxLen, 0);

        return $message ?? '';
    }


    public function connect(): void
    {
        socket_connect($this->socket, $this->config->socketFile);
    }

    public function send(string $message): void
    {
        socket_write($this->socket, $message, strlen($message));
    }

    abstract public function start();
}

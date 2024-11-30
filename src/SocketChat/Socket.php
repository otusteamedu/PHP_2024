<?php

namespace SocketChat;

abstract class Socket
{
    private $socketFile;

    private $length;

    protected $socket;

    public function __construct()
    {
        $arConfig = parse_ini_file(__DIR__ . "/config.ini");
        $this->socketFile = $arConfig["socket_path"];
        $this->length = $arConfig["socket_length"];
    }

    protected function create(): void
    {
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if (!$this->socket) {
            throw new \Exception('Не удалось создать сокет');
        }
    }

    protected function connect(): void
    {
        socket_connect($this->socket, $this->socketFile);
    }

    protected function bind(): void
    {
        socket_bind($this->socket, $this->socketFile);
    }

    protected function accept(): \Socket
    {
        return socket_accept($this->socket);
    }

    protected function listen(): void
    {
        socket_listen($this->socket);
    }

    protected function send(\Socket $socket, string $message): void
    {
        socket_write($socket, $message, strlen($message));
    }

    protected function read(\Socket $socket): string
    {
        if ($message = socket_read($socket, $this->length)) {
            return $message;
        }
        throw new \Exception('Не удалось прочитать сообщение');
    }

    protected function close(): void
    {
        socket_close($this->socket);
    }

    public function getSocket(): \Socket
    {
        return $this->socket;
    }

    abstract public function run(): void;
}
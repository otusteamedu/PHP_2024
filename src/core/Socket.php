<?php

namespace Ali\Socket;

use Exception;

class Socket
{
    public mixed $file;
    public mixed $length;
    public mixed $socket;
    public mixed $client;

    public function __construct($file, $length)
    {
        $this->file = $file;
        $this->length = $length;
        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if (!$socket) {
            throw new Exception("Socket create error: " . socket_strerror(socket_last_error()) . "\n");
        }
        $this->socket = $socket;
    }

    public function bind(): void
    {
        socket_bind($this->socket, $this->file);
    }

    public function listen(): void
    {
        socket_listen($this->socket, 1);
    }

    public function accept(): void
    {
        $this->client = socket_accept($this->socket);
    }

    public function socketConnect(): void
    {
        $this->client = socket_create(AF_UNIX, SOCK_STREAM, 0);
        socket_connect($this->client, $this->file);
    }


    public function sendMessage($msg): false|int
    {
        return socket_write($this->client, $msg);
    }

    public function readMessage(): \Generator
    {
        yield socket_read($this->client, $this->length);
    }

    public function readConfirmation(): false|string
    {
        return socket_read($this->client, $this->length);
    }


    public function closeSession(): void
    {
        socket_close($this->client);
        socket_close($this->socket);
    }
}

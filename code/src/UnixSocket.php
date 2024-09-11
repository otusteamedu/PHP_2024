<?php

declare(strict_types=1);

namespace TimurShakirov\SocketChat;

use Exception;

class UnixSocket
{
    public $file;
    public $length;
    public $socket;
    public $client;

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

    public function bind()
    {
        socket_bind($this->socket, $this->file);
    }

    public function listen()
    {
        socket_listen($this->socket, 1);
    }

    public function accept()
    {
        $this->client = socket_accept($this->socket);
    }

    public function socketConnect()
    {
        socket_connect($this->socket, $this->file);
    }

    public function sendMessage($msg)
    {
        return socket_write($this->socket, $msg);
    }

    public function readMessage()
    {
        $msg = socket_read($this->client, $this->length);

        yield $msg;
    }

    public function closeSession()
    {
        socket_close($this->socket);
    }
}

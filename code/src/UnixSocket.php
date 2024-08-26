<?php

declare(strict_types=1);

namespace PavelMiasnov\PhpSocketChat;

use Exception;

class UnixSocket
{
    public $host;
    public $port;
    public $length;
    public $socket;
    public $client;

    public function __construct($host, $port, $length)
    {
        $this->host = $host;
        $this->port = $port;
        $this->length = $length;
        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if (!$socket) {
            throw new Exception("failed: reason: " . socket_strerror(socket_last_error()) . "\n");
        }
        $this->socket = $socket;
    }

    public function bind()
    {
        socket_bind($this->socket, $this->host, $this->port);
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
        socket_connect($this->socket, $this->host, $this->port);
    }

    public function sendMessage($msg)
    {
        socket_write($this->socket, $msg);
    }

    public function readMessage()
    {
        $msg = socket_read($this->client, $this->length);

        return $msg;
    }

    public function closeSession()
    {
        socket_close($this->socket);
    }
}

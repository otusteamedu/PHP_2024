<?php

namespace Chat\socket;

use Exception;

class UnixSocket
{
    public $host;
    public $port;
    public $maxlen;
    public $socket;
    public $client;

    public function __construct($host, $port, $maxlen)
    {
        $this->host = $host;
        $this->port = $port;
        $this->maxlen = $maxlen;

        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
    }

    public function SocketBind()
    {
        socket_bind($this->socket, $this->host, $this->port);
    }

    public function SocketListen()
    {
        socket_listen($this->socket, 1);
    }

    public function SocketAccept()
    {
        $this->client = socket_accept($this->socket);
    }

    public function SocketConnect()
    {
        socket_connect($this->socket, $this->host, $this->port);
    }

    public function sendMessage($msg)
    {
        socket_write($this->socket, $msg);
    }

    public function readMessage()
    {
        $msg = socket_read($this->client, $this->maxlen, PHP_NORMAL_READ);

        return $msg;
    }

    public function closeSession()
    {
        socket_close($this->socket);
    }
}

<?php

declare(strict_types=1);

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

    public function socketBind()
    {
        socket_bind($this->socket, $this->host, $this->port);
    }

    public function socketListen()
    {
        socket_listen($this->socket, 1);
    }

    public function socketAccept()
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
        $msg = socket_read($this->client, $this->maxlen, PHP_NORMAL_READ);

        return $msg;
    }

    public function closeSession()
    {
        socket_close($this->socket);
    }
}

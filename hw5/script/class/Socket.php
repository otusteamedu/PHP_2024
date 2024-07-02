<?php

namespace HW5;

class Socket
{
    private $socket;
    public function __construct()
    {
        if (!extension_loaded('sockets')) {
            die('The sockets extension is not loaded.');
        }
        $this->socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
        if (!$this->socket) {
            die('Unable to create AF_UNIX socket');
        }
        if (!socket_set_nonblock($this->socket)) {
            die('Unable to set nonblocking mode for socket');
        }
    }

    public function getSocket()
    {
        return $this->socket;
    }
}
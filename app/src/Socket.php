<?php

namespace Evgenyart\UnixSocketChat;

use Exception;

class Socket
{
    private $socket;
    private $socketPath;

    public function __construct($socketPath)
    {
        if (!extension_loaded('sockets')) {
            throw new Exception('The sockets extension is not loaded.');
        }

        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);

        if (!$this->socket) {
            throw new Exception('Unable to create AF_UNIX socket');
        }

        if (!strlen($socketPath)) {
            throw new Exception('Error socket path');
        } else {
            $this->socketPath = $socketPath;
        }
    }

    public function bind()
    {
        if (file_exists($this->socketPath)) {
            unlink($this->socketPath);
        }

        if (!socket_bind($this->socket, $this->socketPath)) {
            throw new Exception('Unable to bind to ' . $this->socketPath);
        }
    }

    public function close()
    {
        if (isset($this->socket)) {
            socket_close($this->socket);
        }
    }

    public function connect()
    {
        if (!socket_connect($this->socket, $this->socketPath)) {
            throw new Exception('Unable connect to ' . $this->socketPath);
        }
    }

    public function send($msg, $res = false)
    {
        $bytes_sent = socket_write(($res ? $res : $this->socket), $msg, strlen($msg));
        if ($bytes_sent == -1) {
            throw new Exception('An error occured while sending to the socket');
        }
    }

    public function read($res = false)
    {
        $message = socket_read(($res ? $res : $this->socket), 4096);

        if (!$message) {
            throw new Exception('Error read message from socket');
        }

        return $message;
    }

    public function listen()
    {
        if (!socket_listen($this->socket)) {
            throw new Exception('Unable to listen socket');
        }
    }

    public function accept()
    {
        $connection = socket_accept($this->socket);

        if (!$connection) {
            throw new Exception('Unable to accept socket');
        }

        return $connection;
    }
}

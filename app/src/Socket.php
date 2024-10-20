<?php

namespace Evgenyart\UnixSocketChat;

use Evgenyart\UnixSocketChat\Exceptions\SocketException;

class Socket
{
    private $socket;
    private $socketPath;

    public function __construct($socketPath)
    {
        if (!extension_loaded('sockets')) {
            throw new SocketException('The sockets extension is not loaded.');
        }

        $this->create();

        if (!strlen($socketPath)) {
            throw new SocketException('Error socket path');
        }

        $this->socketPath = $socketPath;
    }

    public function create($test = false)
    {
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, ($test ? 99 : 1));

        if (!$this->socket) {
            throw new SocketException('Unable to create AF_UNIX socket');
        }

        return $this;
    }

    public function bind($test = false)
    {
        if (file_exists($this->socketPath)) {
            unlink($this->socketPath);
        }

        $resultBind = socket_bind($this->socket, $this->socketPath);

        if ($test) {
            $resultBind = false;
        }

        if (!$resultBind) {
            throw new SocketException('Unable to bind to ' . $this->socketPath);
        } else {
            return $this;
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
        $resultConnect = socket_connect($this->socket, $this->socketPath);
        if (!$resultConnect) {
            throw new SocketException('Unable connect to ' . $this->socketPath);
        } else {
            return $this;
        }
    }

    public function send($msg, $res = false)
    {
        $bytes_sent = socket_write(($res ? $res : $this->socket), $msg, strlen($msg));
        if ($bytes_sent == -1) {
            throw new SocketException('An error occured while sending to the socket');
        }
    }

    public function read($res = false)
    {
        $message = socket_read(($res ? $res : $this->socket), 4096);

        if (!$message) {
            throw new SocketException('Error read message from socket');
        }

        return $message;
    }

    public function listen()
    {
        $resultListen = socket_listen($this->socket);

        if (!$resultListen) {
            throw new SocketException('Unable to listen socket');
        } else {
            return $this;
        }
    }

    public function accept()
    {
        $connection = socket_accept($this->socket);

        if (!$connection) {
            throw new SocketException('Unable to accept socket');
        }

        return $connection;
    }
}

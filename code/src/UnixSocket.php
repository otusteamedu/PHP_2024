<?php

namespace AlexAgapitov\OtusComposerProject;

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
        return $this;
    }

    public function create(bool $test = false)
    {
        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if (!$socket || $test) {
            throw new Exception("Socket create error");
        }
        $this->socket = $socket;
        return $this;
    }

    public function bind()
    {
        if (!isset($this->socket) || !socket_bind($this->socket, $this->file)) {
            throw new Exception('Error to bind');
        }
        return $this;
    }

    public function listen()
    {
        if (!isset($this->socket) || !socket_listen($this->socket, 1)) {
            throw new Exception('Error to listen');
        }
        return $this;
    }

    public function accept()
    {
        if (!isset($this->socket) || false === ($this->client = socket_accept($this->socket))) {
            throw new Exception('Error to accept');
        }
        return $this;
    }

    public function socketConnect()
    {
        if (!isset($this->socket) || !socket_connect($this->socket, $this->file)) {
            throw new Exception('Error to connect');
        }
        return $this;
    }

    public function sendMessage($msg)
    {
        if (!isset($this->socket) || !($res = socket_write($this->socket, $msg))) {
            throw new Exception('Error send message');
        }
        return $res;
    }

    public function readMessage()
    {
        if (!isset($this->client) || !($message = socket_read($this->client, $this->length))) {
            throw new Exception('Error read message');
        }
        yield $message;
    }

    public function closeSession()
    {
        if (!isset($this->socket)) {
            throw new Exception('Error close session');
        }
        socket_close($this->socket);
    }
}
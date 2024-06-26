<?php

declare(strict_types=1);

namespace Otus\Chat;

class Socket
{
    private $socket;

    public function __construct(private string $path)
    {
        if (!extension_loaded('sockets')) {
            throw new \Exception('The sockets extension is not loaded.');
        }

        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if (!$this->socket) {
            throw new \Exception('Unable to create AF_UNIX socket');
        }
    }

    public function bind()
    {
        if (file_exists($this->path)) {
            unlink($this->path);
        }

        if (!socket_bind($this->socket, $this->path)) {
            throw new \Exception("Unable to bind to " . $this->path);
        }
    }

    public function connect()
    {
        if (!socket_connect($this->socket, $this->path)) {
            throw new \Exception("Unable to connect to " . $this->path);
        }
    }

    public function accept()
    {
        $accept = socket_accept($this->socket);

        if (!$accept) {
            throw new \Exception('Unable to accept socket');
        }

        return $accept;
    }

    public function listen()
    {
        if (!socket_listen($this->socket)) {
            throw new \Exception('Socket can not be listened');
        }
    }

    public function send(string $data, $to = false)
    {
        $len = mb_strlen($data, '8bit');
        $target = $to ? $to : $this->socket;
        $bytes_sent = socket_write($target, $data, $len);
        if ($bytes_sent == -1) {
            throw new \Exception('An error occured while sending to the socket');
        }
        if ($bytes_sent != $len) {
            throw new \Exception(+$bytes_sent . ' bytes have been sent instead of the ' . $len . ' bytes expected');
        }
    }

    public function read($from = false): string
    {
        $source = $from ? $from : $this->socket;
        $data = socket_read($source, 65536);
        if (!$data) {
            throw new \Exception('An error occured while receiving from the socket');
        }
        return trim($data);
    }

    public function close()
    {
        socket_close($this->socket);
        if (file_exists($this->path)) {
            unlink($this->path);
        }
        echo 'Socket ' . $this->path . " closed\n";
    }
}

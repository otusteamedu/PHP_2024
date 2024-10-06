<?php

namespace TBublikova\Php2024;

class Socket
{
    public $socket;

    public function __construct(private string $path)
    {
        if (!extension_loaded('sockets')) {
            throw new \RuntimeException('The sockets extension is not loaded.');
        }

        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if (!$this->socket) {
            throw new \RuntimeException('Unable to create AF_UNIX socket');
        }
    }

    public function bindAndListen(): void
    {
        if (file_exists($this->path)) {
            unlink($this->path);
        }

        if (!socket_bind($this->socket, $this->path)) {
            throw new \RuntimeException("Unable to bind to {$this->path}");
        }
        if (!socket_listen($this->socket)) {
            throw new \RuntimeException('Unable to listen on socket');
        }
    }

    public function accept(): \Socket
    {
        $clientSocket = socket_accept($this->socket);
        if ($clientSocket === false) {
            throw new \RuntimeException('Unable to accept connection');
        }
        return $clientSocket;
    }

    public function receive($socket, &$buf): int
    {
        if (!socket_set_block($socket)) {
            throw new \RuntimeException('Unable to set blocking mode for socket');
        }

        $bytesReceived = socket_recv($socket, $buf, 65536, 0);
        if ($bytesReceived === false) {
            throw new \RuntimeException('Unable to receive data');
        }

        return $bytesReceived;
    }

    public function send($socket, string $msg): int
    {
        if (!socket_set_nonblock($socket)) {
            throw new \RuntimeException('Unable to set nonblocking mode for socket');
        }

        $len = strlen($msg);
        $bytesSent = socket_send($socket, $msg, $len, 0);
        if ($bytesSent === false) {
            throw new \RuntimeException('Unable to send data');
        }

        return $bytesSent;
    }

    public function connect()
    {
        if (!socket_connect($this->socket, $this->path)) {
            throw new \RuntimeException('Unable to connect to ' . $this->path);
        }
    }

    public function close($socket = null): void
    {
        if ($socket) {
            socket_close($socket);
        } else {
            socket_close($this->socket);
        }
    }

    public function getSocket()
    {
        return $this->socket;
    }
}

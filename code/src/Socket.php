<?php

declare(strict_types=1);

namespace Otus\Chat;

class Socket
{
    private $socket;
    public $serverPath;
    public $clientPath;

    public function __construct()
    {
        $this->serverPath = dirname(__FILE__) . '/server.sock';
        $this->clientPath = dirname(__FILE__) . '/client.sock';
    }

    public function init($path)
    {
        if (!extension_loaded('sockets'))
            new Error('The sockets extension is not loaded.');

        if (file_exists($path))
            unlink($path);

        $this->socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
        if (!$this->socket)
            new Error('Unable to create AF_UNIX socket');

        socket_bind($this->socket, $path) ||
            new Error("Unable to bind to " . $path);

        return $this->socket;
    }

    public function receive(): string
    {
        socket_set_block($this->socket) ||
            new Error('Unable to set blocking mode for socket');

        $buf = '';
        $from = '';
        $bytes_received = socket_recvfrom($this->socket, $buf, 65536, 0, $from);
        if ($bytes_received == -1)
            new Error('An error occured while receiving from the socket');

        return $buf;
    }

    public function send(string $data, $path)
    {
        socket_set_nonblock($this->socket) ||
            new Error('Unable to set nonblocking mode for socket');

        $len = strlen($data);
        $bytes_sent = socket_sendto($this->socket, $data, $len, 0, $path);
        if ($bytes_sent == -1)
            new Error('An error occured while sending to the socket');
        if ($bytes_sent != $len)
            new Error($bytes_sent . ' bytes have been sent instead of the ' . $len . ' bytes expected');
    }

    public function close($path)
    {
        socket_close($this->socket);
        unlink($path);
        echo 'Socket ' . $path . " closed\n";
    }
}

<?php

declare(strict_types=1);

namespace Otus\Chat;

class Socket
{
    private $socket;
    private $socketPath;

    public function __construct()
    {
        $this->socketPath = dirname(__FILE__) . '/server.sock';
    }

    public function init()
    {
        if (!extension_loaded('sockets'))
            new Error('The sockets extension is not loaded.');

        if (file_exists($this->socketPath))
            unlink($this->socketPath);

        $this->socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
        if (!$this->socket)
            new Error('Unable to create AF_UNIX socket');

        socket_bind($this->socket, $this->socketPath) ||
            new Error("Unable to bind to " . $this->socketPath);

        return $this->socket;
    }

    public function receive(): string
    {
        socket_set_block($this->socket) ||
            new Error('Unable to set blocking mode for socket');

        $buf = '';
        $from = '';
        echo "Awaiting incoming message...\n";

        $bytes_received = socket_recvfrom($this->socket, $buf, 65536, 0, $from);
        if ($bytes_received == -1)
            new Error('An error occured while receiving from the socket');

        echo 'Received ' . $bytes_received . ' bytes from ' . $from . "\n";

        return $buf;
    }

    public function send(string $data)
    {
        socket_set_nonblock($this->socket) ||
            new Error('Unable to set nonblocking mode for socket');

        $len = strlen($data);
        $bytes_sent = socket_sendto($this->socket, $data, $len, 0, $this->socketPath);
        if ($bytes_sent == -1)
            new Error('An error occured while sending to the socket');
        if ($bytes_sent != $len)
            new Error($bytes_sent . ' bytes have been sent instead of the ' . $len . ' bytes expected');

        echo "Request processed\n";
    }

    public function close()
    {
        socket_close($this->socket);
        unlink($this->socketPath);
        echo 'Socket ' . $this->socketPath . " closed\n";
    }
}

<?php

declare(strict_types=1);

namespace Otus\Chat;

use Exception;

class Socket
{
    private $socket;

    /**
     * @throws Exception
     */
    public function __construct(private string $path)
    {
        if (!extension_loaded('sockets')) {
            throw new Exception('The sockets extension is not loaded.');
        }

        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if (!$this->socket) {
            throw new Exception('Unable to create AF_UNIX socket');
        }
    }

    /**
     * @throws Exception
     */
    public function bind(): void
    {
        if (file_exists($this->path)) {
            unlink($this->path);
        }

        if (!socket_bind($this->socket, $this->path)) {
            throw new Exception("Unable to bind to " . $this->path);
        }
    }

    /**
     * @throws Exception
     */
    public function connect(): void
    {
        if (!socket_connect($this->socket, $this->path)) {
            throw new Exception("Unable to connect to " . $this->path);
        }
    }

    /**
     * @throws Exception
     */
    public function accept()
    {
        $accept = socket_accept($this->socket);

        if (!$accept) {
            throw new Exception('Unable to accept socket');
        }

        return $accept;
    }

    /**
     * @throws Exception
     */
    public function listen(): void
    {
        if (!socket_listen($this->socket)) {
            throw new Exception('Socket can not be listened');
        }
    }

    /**
     * @throws Exception
     */
    public function send(string $data, $to = false): void
    {
        $len = mb_strlen($data, '8bit');
        $target = $to ?: $this->socket;
        $bytes_sent = socket_write($target, $data, $len);
        if ($bytes_sent == -1) {
            throw new Exception('An error occurred while sending to the socket');
        }
        if ($bytes_sent != $len) {
            throw new Exception(+$bytes_sent . ' bytes have been sent instead of the ' . $len . ' bytes expected');
        }
    }

    /**
     * @throws Exception
     */
    public function read($from = false): string
    {
        $source = $from ? $from : $this->socket;
        $data = socket_read($source, 65536);
        if (!$data) {
            throw new Exception('An error occurred while receiving from the socket');
        }
        return trim($data);
    }

    public function close(): void
    {
        socket_close($this->socket);
        if (file_exists($this->path)) {
            unlink($this->path);
        }
        echo 'Socket ' . $this->path . " closed\n";
    }
}

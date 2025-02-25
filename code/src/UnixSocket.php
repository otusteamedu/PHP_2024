<?php

declare(strict_types=1);

namespace PavelMiasnov\PhpSocketChat;

use Exception;

class UnixSocket
{
    public string $host;
    public int $port;
    public int $length;
    public $socket;
    public $client;

    /**
     * @throws Exception
     */
    public function __construct($host, $port, $length)
    {
        $this->host = $host;
        $this->port = $port;
        $this->length = $length;
        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if (!$socket) {
            throw new Exception("Failed to create socket: " . socket_strerror(socket_last_error()) . "\n");
        }
        $this->socket = $socket;
    }

    /**
     * @throws Exception
     */
    public function bind(): void
    {
        if (!socket_bind($this->socket, $this->host)) {
            throw new Exception("Failed to bind socket: " . socket_strerror(socket_last_error($this->socket)) . "\n");
        }
    }

    /**
     * @throws Exception
     */
    public function listen(): void
    {
        if (!socket_listen($this->socket, 1)) {
            throw new Exception("Failed to listen on socket: " . socket_strerror(socket_last_error($this->socket)) . "\n");
        }
    }

    /**
     * @throws Exception
     */
    public function accept(): void
    {
        $client = socket_accept($this->socket);
        if (!$client) {
            throw new Exception("Failed to accept connection: " . socket_strerror(socket_last_error($this->socket)) . "\n");
        }
        $this->client = $client;
    }

    /**
     * @throws Exception
     */
    public function socketConnect(): void
    {
        if (!socket_connect($this->socket, $this->host)) {
            throw new Exception("Failed to connect socket: " . socket_strerror(socket_last_error($this->socket)) . "\n");
        }
    }

    /**
     * @throws Exception
     */
    public function sendMessage($msg): void
    {
        if (!socket_write($this->socket, $msg, strlen($msg))) {
            throw new Exception("Failed to send message: " . socket_strerror(socket_last_error($this->socket)) . "\n");
        }
    }

    /**
     * @throws Exception
     */
    public function readMessage(): string
    {
        if ($this->client === null) {
            throw new Exception("No client connection established");
        }
        $msg = socket_read($this->client, $this->length);
        if ($msg === false) {
            throw new Exception("Failed to read message: " . socket_strerror(socket_last_error($this->client)) . "\n");
        }
        return $msg;
    }

    public function closeSession(): void
    {
        if (is_resource($this->client)) {
            socket_close($this->client);
        }
        if (is_resource($this->socket)) {
            socket_close($this->socket);
        }
    }
}

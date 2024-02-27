<?php

declare(strict_types=1);

namespace Kagirova\Hw5;

use Socket;

class UnixSocket
{
    private ?Socket $socket = null;
    private int $max_message_length;
    private string $socket_address;
    private string $port;

    public function __construct()
    {
        $data = parse_ini_file(dirname(__DIR__) . '/app.ini');
        if (false === $data) {
            throw new \RuntimeException('Unable to parse config.ini');
        }
        $this->max_message_length = $data['max_message_length'];
        $this->socket_address = $data['socket_address'];
        $this->port = $data['port'];
    }


    public function create(bool $clear)
    {
        if ($clear) {
            if (file_exists($this->socket_address)) {
                unlink($this->socket_address);
            }
        }
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if ($this->socket === false) {
            throw new \Exception("socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n");
        }
    }

    public function bind()
    {
        if ((socket_bind($this->socket, $this->socket_address, $this->port)) === false) {
            throw new \Exception("socket_bind() failed: reason: " . socket_strerror(socket_last_error($this->socket)) . "\n");
        }
    }


    public function connect()
    {
        $result = socket_connect($this->socket, $this->socket_address, $this->port);
        if ($result === false) {
            throw new \Exception("socket_connect() failed.\nReason: ($result) " . socket_strerror(socket_last_error($this->socket)) . "\n");
        }
    }

    public function listen()
    {
        if ((socket_listen($this->socket, 10)) === false) {
            throw new \Exception("socket_listen() failed: reason: " . socket_strerror(socket_last_error($this->socket)) . "\n");
        }

    }

    public function accept()
    {
        if (($connection = socket_accept($this->socket)) === false) {
            throw new \Exception("socket_accept() failed: reason: " . socket_strerror(socket_last_error($this->socket)) . "\n");
        }
        return $connection;
    }

    public function read(Socket $socket = null)
    {
        $connection = $socket ?? $this->socket;

        if (($message = socket_read($connection, $this->max_message_length)) === false) {
            throw new \Exception("socket_read() failed: reason: " . socket_strerror(socket_last_error($connection)) . "\n");
        }
        return $message;
    }

    public function write($message, Socket $socket = null)
    {
        $connection = $socket ?? $this->socket;
        if (socket_write($connection, $message) === false) {
            throw new \Exception("socket_write() failed: reason: " . socket_strerror(socket_last_error($connection)) . "\n");
        }

    }

    public function close(Socket $socket = null)
    {
        $connection = $socket ?? $this->socket;
        socket_close($connection);
    }
}
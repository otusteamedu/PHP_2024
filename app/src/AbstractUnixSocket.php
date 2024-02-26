<?php

namespace Otus\Hw5;

abstract class AbstractUnixSocket
{
    protected \Socket $socket;

    private string $socketFile;
    private string $bufferLength;

    public function __construct()
    {
        $this->socketFile = getenv('SOCKET_FILE');
        $this->bufferLength = getenv('BUFFER_LENGTH');
    }

    /**
     * @return void
     * @throws \Exception
     */
    protected function recreate(): void
    {
        if (file_exists($this->socketFile) && !unlink($this->socketFile)) {
            throw new \Exception('Failed to re-create socket!');
        }
    }

    /**
     * @return void
     * @throws \Exception
     */
    protected function create(): void
    {
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);

        if ($this->socket === false) {
            throw new \Exception("Failed to create socket: " . socket_strerror(socket_last_error()));
        }
    }

    /**
     * @return void
     * @throws \Exception
     */
    protected function bind(): void
    {
        if (!socket_bind($this->socket, $this->socketFile)) {
            throw new \Exception("Failed to bind socket: " . socket_strerror(socket_last_error()));
        }
    }

    /**
     * @return void
     * @throws \Exception
     */
    protected function listen(): void
    {
        if (!socket_listen($this->socket)) {
            throw new \Exception("Failed to listen on socket: " . socket_strerror(socket_last_error()));
        }
    }

    /**
     * @return \Socket|false
     * @throws \Exception
     */
    protected function accept(): \Socket|false
    {
        $client = socket_accept($this->socket);
        if ($client === false) {
            throw new \Exception("Failed to accept incoming connection: " . socket_strerror(socket_last_error()));
        }

        return $client;
    }

    /**
     * @return void
     * @throws \Exception
     */
    protected function connect(): void
    {
        if (!socket_connect($this->socket, $this->socketFile)) {
            throw new \Exception("Failed to connect to socket: " . socket_strerror(socket_last_error()));
        }
    }

    /**
     * @param string $message
     * @return void
     * @throws \Exception
     */
    protected function send(string $message): void
    {
        if (socket_write($this->socket, $message, strlen($message)) === false) {
            throw new \Exception("Failed to send data to socket: " . socket_strerror(socket_last_error()));
        }
    }

    /**
     * @param $socket
     * @return string
     * @throws \Exception
     */
    protected function receive($socket): string
    {
        $message = socket_read($socket, $this->bufferLength);
        if ($message === false) {
            throw new \Exception("Failed to read data from socket: " . socket_strerror(socket_last_error()));
        }

        return $message;
    }

    /**
     * @return void
     */
    protected function close()
    {
        socket_close($this->socket);
    }

    /**
     * @return void
     */
    abstract public function startChat(): void;
}

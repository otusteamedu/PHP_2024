<?php

namespace Dsergei\Hw5;

abstract class AbstractSocket
{
    private string $socketFile;

    private string $length;

    protected \Socket $socket;

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        $this->socketFile = getenv('SOCKET_FILE');
        $this->length = getenv('MAX_LENGTH_DATA');
    }

    /**
     * @return void
     * @throws \Exception
     */
    protected function create(): void
    {
        $result = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if ($result === false) {
            throw new \Exception("Error while create socket");
        }

        $this->socket = $result;
    }

    /**
     * @return void
     */
    protected function connect(): void
    {
        socket_connect($this->socket, $this->socketFile);
    }

    /**
     * @return void
     */
    protected function bind(): void
    {
        socket_bind($this->socket, $this->socketFile);
    }

    /**
     * @return false|resource|\Socket
     */
    protected function accept()
    {
        return socket_accept($this->socket);
    }

    /**
     * @return void
     */
    protected function listen(): void
    {
        socket_listen($this->socket);
    }

    /**
     * @param string $message
     * @return void
     */
    protected function send(string $message): void
    {
        socket_write($this->socket, $message, strlen($message));
    }

    /**
     * @param $socket
     * @return string
     */
    protected function receive($socket): string
    {
        if (!$socket) {
            return '';
        }

        socket_recv($socket, $message, $this->length, 0);

        return $message ?? '';
    }

    /**
     * @return void
     */
    protected function close(): void
    {
        socket_close($this->socket);
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        if (file_exists($this->socketFile)) {
            unlink($this->socketFile);
        }
    }

    /**
     * @return void
     */
    abstract public function init(): void;
}

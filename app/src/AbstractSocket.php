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
        $this->log()->send('Create socket');

        $result = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if ($result === false) {
            throw new \Exception("Error while create socket");
        }

        $this->log()->send('Socket created success');
        $this->socket = $result;
    }

    /**
     * @return void
     */
    protected function connect(): void
    {
        $this->log()->send('Connect to socket');
        socket_connect($this->socket, $this->socketFile);
        $this->log()->send('Connected to socket success');
    }

    /**
     * @return void
     */
    protected function bind(): void
    {
        $this->log()->send('Bind to socket');
        socket_bind($this->socket, $this->socketFile);
        $this->log()->send('Binded to socket success');
    }

    /**
     * @return false|resource|\Socket
     */
    protected function accept()
    {
        $this->log()->send('Wait socket');
        return socket_accept($this->socket);
    }

    /**
     * @return void
     */
    protected function listen(): void
    {
        $this->log()->send('Listen to socket');
        socket_listen($this->socket);
        $this->log()->send('Listening socket success');
    }

    /**
     * @param string $message
     * @return void
     */
    protected function send(string $message): void
    {
        $this->log()->send('Send to socket');
        socket_write($this->socket, $message, strlen($message));
        $this->log()->send('Sended to socket success');
    }

    /**
     * @param $socket
     * @return string
     */
    protected function receive($socket): string
    {
        if (!$socket) {
            $this->log()->send('Receive socket fail');
        }

        socket_recv($socket, $message, $this->length, 0);

        $this->log()->send("Received socket message: {$message}");

        return $message;
    }

    /**
     * @return void
     */
    protected function close(): void
    {
        $this->log()->send('Close socket');
        socket_close($this->socket);
        $this->log()->send('Closed socket success');
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        if (file_exists($this->socketFile)) {
            unlink($this->socketFile);
            $this->log()->send("Remove old socket");
        }
    }

    /**
     * @return \Generator
     */
    public function log(): \Generator
    {
        $string = yield;
        echo $string . PHP_EOL;
    }

    /**
     * @return void
     */
    abstract public function init(): void;
}

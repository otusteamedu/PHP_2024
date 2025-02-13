<?php

namespace SlavaMakhov\OtusTestApp;

use Exception;
use Generator;

class SocketService
{
    public string $file;
    public string $length;
    public $socket;
    public $client;

    /**
     * @param string $file
     * @param string $length
     */
    public function __construct(string $file, string $length)
    {
        $this->file = $file;
        $this->length = $length;

        return $this;
    }

    /**
     * Метод создает сокет
     *
     * @param bool $exceptionTest
     *
     * @return SocketService
     * @throws Exception
     */
    public function create(bool $exceptionTest = false): SocketService
    {
        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);

        if ($exceptionTest || !$socket) {
            throw new Exception("Socket create error");
        }
        $this->socket = $socket;

        return $this;
    }

    /**
     * Метод привязки
     *
     * @return $this
     * @throws Exception
     */
    public function bind()
    {
        if (!isset($this->socket) || !socket_bind($this->socket, $this->file)) {
            throw new Exception('Error to bind');
        }
        return $this;
    }

    /**
     * Метод прослушивает сокет
     *
     * @return $this
     * @throws Exception
     */
    public function listen()
    {
        if (!isset($this->socket) || !socket_listen($this->socket, 1)) {
            throw new Exception('Error to listen');
        }
        return $this;
    }

    /**
     * Метод принимает соединение клиента
     *
     * @return $this
     * @throws Exception
     */
    public function accept()
    {
        if (!isset($this->socket) || false === ($this->client = socket_accept($this->socket))) {
            throw new Exception('Error to accept');
        }
        return $this;
    }

    /**
     * Метод соединяется с сокетом
     *
     * @return $this
     * @throws Exception
     */
    public function socketConnect()
    {
        if (!isset($this->socket) || !socket_connect($this->socket, $this->file)) {
            throw new Exception('Error to connect');
        }
        return $this;
    }

    /**
     * Метод отправки сообщения в указанный сокет
     *
     * @param $msg
     *
     * @return int
     * @throws Exception
     */
    public function sendMessage($msg)
    {
        if (!isset($this->socket) || !($res = socket_write($this->socket, $msg))) {
            throw new Exception('Error send message');
        }
        return $res;
    }

    /**
     * Метод принимает сообщения от указанного сокета
     *
     * @return Generator
     * @throws Exception
     */
    public function readMessage()
    {
        if (!isset($this->client) || !($message = socket_read($this->client, $this->length))) {
            throw new Exception('Error read message');
        }
        yield $message;
    }

    /**
     * Метод закрытия сокета
     *
     * @return void
     * @throws Exception
     */
    public function closeSession()
    {
        if (!isset($this->socket)) {
            throw new Exception('Error close session');
        }
        socket_close($this->socket);
    }
}

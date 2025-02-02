<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusChatSocketsApp;

use Exception;
use Socket;

class SocketService
{
    public $client;

    public $socket;

    /** @var int */
    public int $length;

    /** @var string */
    public string $file;

    /**
     * @throws Exception
     */
    public function __construct(string $file, int $length)
    {
        $this->file = $file;
        $this->length = $length;

        try {
            $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        } catch (Exception $e) {
            throw new Exception('socket_create() failed: ' . socket_strerror(socket_last_error()) . "\n");
        }
    }

    /**
     * Метод привязки
     *
     * @return void
     *
     * @throws Exception
     */
    public function bind(): void
    {
        try {
            socket_bind($this->socket, $this->file);
        } catch (Exception $e) {
            throw new Exception('socket_bind() failed: ' . socket_strerror(socket_last_error()) . "\n");
        }
    }

    /**
     * Метод прослушивает сокет
     *
     * @return void
     *
     * @throws Exception
     */
    public function listen(): void
    {
        try {
            socket_listen($this->socket, 1);
        } catch (Exception $e) {
            throw new Exception('socket_listen() failed: ' . socket_strerror(socket_last_error()) . "\n");
        }
    }

    /**
     * Метод принимает соединение клиента
     *
     * @return void
     *
     * @throws Exception
     */
    public function accept(): void
    {
        try {
            $this->client = socket_accept($this->socket);
        } catch (Exception $e) {
            throw new Exception('socket_accept() failed: ' . socket_strerror(socket_last_error()) . "\n");
        }
    }

    /**
     * Метод соединяется с сокетом
     *
     * @return void
     *
     * @throws Exception
     */
    public function socketConnect(): void
    {
        try {
            socket_connect($this->socket, $this->file);
        } catch (Exception $e) {
            throw new Exception('socket_connect() failed: ' . socket_strerror(socket_last_error()) . "\n");
        }
    }

    /**
     * Метод отправки сообщения в указанный сокет
     *
     * @param Socket $socket
     * @param string $message
     *
     * @return bool|int
     * @throws Exception
     */
    public function sendMessage(Socket $socket, string $message): bool|int
    {
        try {
            return socket_write($socket, $message);
        } catch (Exception $e) {
            throw new Exception('socket_write() failed: ' . socket_strerror(socket_last_error()) . "\n");
        }
    }

    /**
     * Метод принимает сообщения от указанного сокета
     *
     * @throws Exception
     */
    public function readMessage(Socket $socket): string
    {
        try {
            return socket_read($socket, $this->length);
        } catch (Exception $e) {
            throw new Exception('socket_read() failed: ' . socket_strerror(socket_last_error()) . "\n");
        }
    }

    /**
     * Метод закрытия сокета
     *
     * @return void
     * @throws Exception
     */
    public function closeSession(): void
    {
        try {
            socket_close($this->socket);
        } catch (Exception $e) {
            throw new Exception('socket_close() failed: ' . socket_strerror(socket_last_error()) . "\n");
        }
    }

    /**
     * Метод очистки файла сокета
     *
     * @param string $file
     * @return void
     */
    public function clearFile(string $file): void
    {
        if (file_exists($file)) {
            unlink($file);
        }
    }
}

<?php

declare(strict_types=1);

namespace Otus\SocketChat;

use Exception;

class Socket
{
    private $socket;

    /**
     * @throws Exception
     */
    public function __construct(private readonly string $path)
    {
        if (!extension_loaded('sockets')) {
            throw new Exception('Расширение для работы с сокетом не установлено');
        }

        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if (!$this->socket) {
            throw new Exception('Не удалось создать UNIX сокет ');
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
            throw new Exception("Не удалось привязать имя к сокету " . $this->path);
        }
    }

    /**
     * @throws Exception
     */
    public function connect(): void
    {
        if (!socket_connect($this->socket, $this->path)) {
            throw new Exception("Не удалось подключиться к " . $this->path);
        }
    }

    /**
     * @throws Exception
     */
    public function accept()
    {
        $accept = socket_accept($this->socket);

        if (!$accept) {
            throw new Exception('Не удалось принять соединение на сокете');
        }

        return $accept;
    }

    /**
     * @throws Exception
     */
    public function listen(): void
    {
        if (!socket_listen($this->socket)) {
            throw new Exception('Не удалось прослушать входящее соединение на сокете');
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
            throw new Exception('Произошла ошибка при отправке данных в сокет');
        }
        if ($bytes_sent != $len) {
            throw new Exception(+$bytes_sent . ' байт было отправлено вместо ' . $len . ' ожидаемых байтов');
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
            throw new Exception('Произошла ошибка при получении данных из сокета');
        }
        return trim($data);
    }

    public function close(): void
    {
        socket_close($this->socket);
        if (file_exists($this->path)) {
            unlink($this->path);
        }
        echo 'Socket ' . $this->path . " закрыт" . PHP_EOL;
    }
}

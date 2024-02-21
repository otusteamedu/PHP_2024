<?php

declare(strict_types=1);

namespace Afilippov\Hw5;

use Exception;

class Socket
{
    private string $socketPath;

    private int $maxLength;

    protected \Socket $socket;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->socketPath = getenv('SOCKET_PATH');
        $this->maxLength = (int)getenv('MAX_LENGTH');
    }

    /**
     * @throws Exception
     */
    public function create(): void
    {
        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if ($socket === false) {
            throw new Exception("Ошибка создания сокета");
        }

        $this->socket = $socket;
    }

    /**
     * @throws Exception
     */
    public function bind(): void
    {
        $bindResult = socket_bind($this->socket, $this->socketPath);
        if ($bindResult === false) {
            throw new Exception("Ошибка привязки сокета к пути");
        }
    }

    /**
     * @throws Exception
     */
    public function connect(): void
    {
        $connectResult = socket_connect($this->socket, $this->socketPath);
        if ($connectResult === false) {
            throw new Exception("Ошибка подключения к серверу");
        }
    }

    /**
     * @throws Exception
     */
    public function listen(): void
    {
        $listenResult = socket_listen($this->socket);
        if ($listenResult === false) {
            throw new Exception("Ошибка прослушивания сокета");
        }
    }

    /**
     * @throws Exception
     */
    public function accept()
    {
        $clientSocket = socket_accept($this->socket);
        if ($clientSocket === false) {
            throw new Exception("Ошибка принятия подключения");
        }

        return $clientSocket;
    }

    /**
     * @throws Exception
     */
    public function write(string $message): void
    {
        $writeResult = socket_write($this->socket, $message, strlen($message));
        if ($writeResult === false) {
            throw new Exception("Ошибка записи в сокет");
        }
    }

    /**
     * @throws Exception
     */
    public function read(\Socket $socket): string
    {
        $message = socket_read($socket, $this->maxLength);
        if ($message === false) {
            throw new Exception("Ошибка чтения сообщения");
        }

        return $message;
    }

    public function close(): void
    {
        socket_close($this->socket);
    }

    public function removeSockFile(): void
    {
        if (file_exists($this->socketPath)) {
            unlink($this->socketPath);
        }
    }
}

<?php

declare(strict_types=1);

namespace GoroshnikovP\Hw6\SocketManager;

use GoroshnikovP\Hw6\Exceptions\RuntimeException;
use Socket;

abstract class SocketManager
{
    const SOCKET_BUFFER_SIZE = 65536;
/**
* @var Socket через него идет обмен данными. У клиента другого сокета не будет.
     * У сервера, кроме этого сокета, будет главный сокет, подробнее в сервере.
     */
    protected Socket $workingSocket;
    public function __construct(protected string $socketFile)
    {
    }

    abstract public function socketInit(): void;
/**
     * @throws RuntimeException
     */
    public function socketSend($data): void
    {
        $bytesSent = socket_write($this->workingSocket, $data);
        if (false === $bytesSent) {
            throw new RuntimeException("данные отправлены не полностью. " .
                socket_strerror(socket_last_error($this->workingSocket)));
        }
    }

    /**
     * @throws RuntimeException
     */
    public function socketReceive(): string
    {
        $readedData = socket_read($this->workingSocket, static::SOCKET_BUFFER_SIZE, PHP_BINARY_READ);
        if (!$readedData) {
            throw new RuntimeException("данные не получены. " .
                socket_strerror(socket_last_error($this->workingSocket)));
        }

        return $readedData;
    }


    /**
* в случае сервера, будет закрыт не основной сокет, а тот, в рамках которого идет общение с клиентом.
     * Основной сокет останется открытый.
     */
    public function socketClose(): void
    {
        socket_close($this->workingSocket);
    }
}

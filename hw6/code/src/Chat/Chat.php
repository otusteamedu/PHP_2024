<?php

declare(strict_types=1);

namespace GoroshnikovP\Hw6\Chat;

use GoroshnikovP\Hw6\Exceptions\RuntimeException;
use Socket;

abstract class Chat
{
    const CHAT_EXIT = 'chat_exit';
    const SOCKET_BUFFER_SIZE = 65536;
    protected Socket $socket;

    public function __construct(protected string $socketFile)
    {
    }

    /**
     * @throws RuntimeException
     */
    protected function socketInit(): void
    {
        $socket = socket_create(AF_UNIX, SOCK_SEQPACKET, 0);
        if ($socket instanceof Socket) {
            $this->socket = $socket;
            unset($socket);
        } else {
            throw new RuntimeException('не удалось создать сокет');
        }
    }


    /**
     * @throws RuntimeException
     */
    protected function socketSend(Socket $socket, $data): void
    {
        $bytesSent = socket_write($socket, $data);
        if (false === $bytesSent) {
            throw new RuntimeException("данные отправлены не полностью. " .
                socket_strerror(socket_last_error($this->socket)));
        }
    }

    /**
     * @throws RuntimeException
     */
    protected function socketReceive(Socket $socket): string
    {
        $readedData = socket_read($socket, static::SOCKET_BUFFER_SIZE, PHP_BINARY_READ);

        if (!$readedData) {
            throw new RuntimeException("данные не получены. " .
                socket_strerror(socket_last_error($socket)));
        }

        return $readedData;
    }

    abstract public function run(): void;
}

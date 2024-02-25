<?php

declare(strict_types=1);

namespace GoroshnikovP\Hw6\SocketManager;

use GoroshnikovP\Hw6\Exceptions\RuntimeException;
use Socket;

class ClientSocketManager extends SocketManager
{
    /**
     * @throws RuntimeException
     */
    public function socketInit(): void
    {
        if (!file_exists($this->socketFile)) {
            throw new RuntimeException("Похоже, сервер не запущен. ");
        }

        $socket = socket_create(AF_UNIX, SOCK_SEQPACKET, 0);
        if (!($socket instanceof Socket)) {
            throw new RuntimeException('не удалось создать сокет');
        }
        $this->workingSocket = $socket;
        unset($socket);
        if (!socket_connect($this->workingSocket, $this->socketFile)) {
            throw new RuntimeException("Не удалось подключиться к сокету. " .
                socket_strerror(socket_last_error($this->workingSocket)));
        }
    }
}

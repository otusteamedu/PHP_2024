<?php

declare(strict_types=1);

namespace App\src\Socket;

use App\src\Contracts\ProcessInterface;
use Exception;
use Socket;

abstract class AbstractProcess implements ProcessInterface
{
    protected ?Socket $socket = null;

    protected bool $runProcess = true;

    protected const MAX_MESSAGE_LENGTH = 2048;

    /**
     * @throws Exception
     */
    public function __construct(protected string $socketPath)
    {
        $this->init();
    }

    /**
     * @throws Exception
     */
    public function read(Socket $socket): string
    {
        return socket_read($socket, self::MAX_MESSAGE_LENGTH);
    }

    /**
     * @throws Exception
     */
    public function write(string $message, Socket $socket): bool|int
    {
        return socket_write($socket, $message, strlen($message));
    }

    /**
     * @throws Exception
     */
    protected function accept(): Socket
    {
        if (socket_accept($this->socket) === false) {
            throw new Exception('Ошибка при привязке сокета.');
        }

        return socket_accept($this->socket);
    }

    /**
     * @throws Exception
     */
    protected function create(): bool|Socket
    {
        $this->socket = socket_create(AF_UNIX, SOCK_SEQPACKET, 0);

        return $this->socket or throw new Exception('Ошибка при создании сокета.');
    }

    /**
     * @throws Exception
     */
    protected function bind(): void
    {
        socket_bind($this->socket, $this->socketPath) or throw new Exception('Ошибка при связи с сокетом.');
    }

    protected function close(): void
    {
        if ($this->socket) {
            socket_close($this->socket);
        }
    }

}
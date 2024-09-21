<?php

declare(strict_types=1);

namespace App\Service;

use App\Interface\UnixSocketInterface;
use Exception;
use Generator;
use Socket;

class SocketService implements UnixSocketInterface
{
    /**
     * @var Socket
     */
    private Socket $socket;

    /**
     * @return void
     * @throws Exception
     */
    public function create(): void
    {
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);

        if (!$this->socket) {
            throw new Exception('SocketService create error');
        }
    }

    /**
     * @return void
     * @throws Exception
     */
    public function bind(): void
    {
        if (socket_bind($this->socket,  $this->getStoragePath()) === false) {
            throw new Exception('SocketService bind error');
        }
    }

    /**
     * @return void
     * @throws Exception
     */
    public function listen(): void
    {
        if (socket_listen($this->socket) === false) {
            throw new Exception('SocketService listen error');
        }
    }

    /**
     * @return Socket
     * @throws Exception
     */
    public function accept(): Socket
    {
        if (($connect = socket_accept($this->socket)) === false) {
            throw new Exception('SocketService accept error');
        }

        return $connect;
    }

    /**
     * @param Socket|null $connect
     * @return string|false
     * @throws Exception
     */
    public function read(Socket $connect = null): string|false
    {
        if (($message = socket_read($connect ?? $this->socket, 2048)) === false) {
            throw new Exception('SocketService read error');
        }

        return $message;
    }

    /**
     * @param Socket|null $connect
     * @return Generator
     * @throws Exception
     */
    public function getReadGenerator(Socket $connect = null): Generator
    {
        while ($connect ?? $this->socket) {
            if (($message = socket_read($connect ?? $this->socket, 2048)) === false) {
                throw new Exception('SocketService read error');
            }
            yield $message;
        }
    }

    /**
     * @return void
     * @throws Exception
     */
    public function connect(): void
    {
        if ((socket_connect($this->socket, $this->getStoragePath())) === false) {
            throw new Exception("SocketService connect error");
        }
    }

    /**
     * @param string $message
     * @param Socket|null $connect
     * @return void
     * @throws Exception
     */
    public function write(string $message, Socket $connect = null): void
    {
        if ((socket_write($connect ?? $this->socket, $message)) === false) {
            throw new Exception("SocketService write error");
        }
    }

    /**
     * @param Socket|null $connect
     * @return void
     */
    public function close(Socket $connect = null): void
    {
        socket_close($connect ?? $this->socket);
    }

    /**
     * @return void
     */
    public function unlink(): void
    {
        unlink($this->getStoragePath());
    }

    /**
     * @return string
     */
    private function getStoragePath(): string
    {
        $config = ConfigService::class;

        return $config::get('STORAGE_PATH') . '/' . $config::get('STORAGE_NAME');
    }
}

<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\SocketException;
use App\Interface\UnixSocketInterface;
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
     * @throws SocketException
     */
    public function create(): void
    {
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);

        if (!$this->socket) {
            throw new SocketException('SocketService create error');
        }
    }

    /**
     * @return void
     * @throws SocketException
     */
    public function bind(): void
    {
        if (socket_bind($this->socket, $this->getSocketPath()) === false) {
            throw new SocketException('SocketService bind error');
        }
    }

    /**
     * @return void
     * @throws SocketException
     */
    public function listen(): void
    {
        if (socket_listen($this->socket) === false) {
            throw new SocketException('SocketService listen error');
        }
    }

    /**
     * @return Socket
     * @throws SocketException
     */
    public function accept(): Socket
    {
        if (($connect = socket_accept($this->socket)) === false) {
            throw new SocketException('SocketService accept error');
        }

          return $connect;
    }

    /**
     * @param Socket|null $connect
     * @return string|false
     * @throws SocketException
     */
    public function read(Socket $connect = null): string|false
    {
        if (($message = socket_read($connect ?? $this->socket, 2048)) === false) {
            throw new SocketException('SocketService read error');
        }

        return $message;
    }

    /**
     * @param Socket|null $connect
     * @return Generator
     * @throws SocketException
     */
    public function getReadGenerator(Socket $connect = null): Generator
    {
        while ($connect ?? $this->socket) {
            if (($message = socket_read($connect ?? $this->socket, 2048)) === false) {
                throw new SocketException('SocketService read error');
            }
            yield $message;
        }
    }

    /**
     * @return void
     * @throws SocketException
     */
    public function connect(): void
    {
        if ((socket_connect($this->socket, $this->getSocketPath())) === false) {
            throw new SocketException("SocketService connect error");
        }
    }

    /**
     * @param string $message
     * @param Socket|null $connect
     * @return void
     * @throws SocketException
     */
    public function write(string $message, Socket $connect = null): void
    {
        if ((socket_write($connect ?? $this->socket, $message)) === false) {
            throw new SocketException("SocketService write error");
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
        if (file_exists($this->getSocketPath())) {
            unlink($this->getSocketPath());
        }
    }

    /**
     * @return string
     */
    private function getSocketPath(): string
    {
        $config = ConfigService::class;

        return $config::get('SOCKET_PATH') . '/' . $config::get('SOCKET_NAME');
    }
}

<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Exception\SocketException;
use App\Domain\Interface\UnixSocketInterface;
use Generator;
use Socket;

class SocketService implements UnixSocketInterface
{
    /**
     * @var Socket|false
     */
    private Socket|false $socket;

    /**
     * @return $this
     * @throws SocketException
     */
    public function create(): self
    {
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);

        // @codeCoverageIgnoreStart
        if (!$this->socket) {
            throw new SocketException('SocketService create error');
        }
        // @codeCoverageIgnoreEnd

        return $this;
    }

    /**
     * @return $this
     * @throws SocketException
     */
    public function bind(): self
    {
        if (socket_bind($this->socket, $this->getSocketPath()) === false) {
            // @codeCoverageIgnoreStart
            throw new SocketException('SocketService bind error');
            // @codeCoverageIgnoreEnd
        }

        return $this;
    }

    /**
     * @return $this
     * @throws SocketException
     */
    public function listen(): self
    {
        if (socket_listen($this->socket) === false) {
            // @codeCoverageIgnoreStart
            throw new SocketException('SocketService listen error');
            // @codeCoverageIgnoreEnd
        }

        return $this;
    }

    /**
     * @return Socket
     * @throws SocketException
     */
    public function accept(): Socket
    {
        if (($connect = socket_accept($this->socket)) === false) {
            // @codeCoverageIgnoreStart
            throw new SocketException('SocketService accept error');
            // @codeCoverageIgnoreEnd
        }

          return $connect;
    }

    /**
     * @param Socket|null $connect
     * @return Generator
     * @throws SocketException
     */
    public function getReadGenerator(Socket $connect = null): Generator
    {
        while ($connect ?? $this->socket) {
            // @codeCoverageIgnoreStart
            if (($message = socket_read($connect ?? $this->socket, 2048)) === false) {
                throw new SocketException('SocketService read error');
            }
            // @codeCoverageIgnoreEnd

            yield $message;
        }
    }

    /**
     * @return $this
     * @throws SocketException
     */
    public function connect(): self
    {
        if ((socket_connect($this->socket, $this->getSocketPath())) === false) {
        // @codeCoverageIgnoreStart
            throw new SocketException("SocketService connect error");
        // @codeCoverageIgnoreEnd
        }

        return $this;
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
        // @codeCoverageIgnoreStart
            throw new SocketException("SocketService write error");
        // @codeCoverageIgnoreEnd
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
    public function getSocketPath(): string
    {
        $config = ConfigService::class;

        return $config::get('SOCKET_PATH') . '/' . $config::get('SOCKET_NAME');
    }
}

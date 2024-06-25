<?php

declare(strict_types=1);

namespace Viking311\Chat\Socket;

class Socket
{
    /** @var string  */
    private string $socketPath;
    /** @var \Socket|null  */
    public ?\Socket $socket = null;
    /** @var \Socket|null  */
    private ?\Socket $connect = null;

    /**
     * @param string $socketPath
     */
    public function __construct(string $socketPath)
    {
        $this->socketPath = $socketPath;
    }

    /**
     * @return $this
     * @throws SocketException
     */
    public function create(): static
    {
        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if ($socket === false) {
            throw new SocketException(
                'socket_create() failed: '
                . socket_strerror(socket_last_error())
            );
        }
        $this->socket = $socket;

        return $this;
    }

    /**
     * @param bool $reset
     *
     * @return $this
     * @throws SocketException
     */
    public function bind(bool $reset = false): static
    {
        if ($reset && file_exists($this->socketPath)) {
            unlink($this->socketPath);
        }

        if (socket_bind($this->socket, $this->socketPath) === false) {
            throw new SocketException('socket_bind() failed: '
                . socket_strerror(socket_last_error($this->socket))
            );
        }

        return $this;
    }

    /**
     * @return $this
     * @throws SocketException
     */
    public function connect(): static
    {
        if (socket_connect($this->socket, $this->socketPath) === false) {
            throw new SocketException(
                'socket_connect() failed: '
                . socket_strerror(socket_last_error())
            );
        }

        return $this;
    }

    /**
     * @throws SocketException
     */
    public function accept()
    {
        $connect = socket_accept($this->socket);
        if ($connect === false) {
            throw new SocketException(
                'socket_accept() failed: '
                . socket_strerror(socket_last_error())
            );
        }
        $this->connect = $connect;

        return $connect;
    }

    /**
     * @param int $backlog
     *
     * @return $this
     * @throws SocketException
     */
    public function listen(int $backlog = 0): static
    {
        if (socket_listen($this->socket, $backlog) === false) {
            throw new SocketException(
                'socket_listen() failed: '
                . socket_strerror(socket_last_error())
            );
        }

        return $this;
    }

    /**
     * @param int $length
     *
     * @return string
     * @throws SocketException
     */
    public function read(int $length = 1024): string
    {
        $sc = $this->connect ?? $this->socket;
        $result = socket_read($sc, $length);
        if ($result === false) {
            throw new SocketException(
                'socket_read() failed: '
                . socket_strerror(socket_last_error())
            );
        }

        return $result;
    }

    /**
     * @param string $data
     *
     * @return void
     * @throws SocketException
     */
    public function write(string $data): void
    {
        $sc = $this->connect ?? $this->socket;
        $result = socket_write($sc, $data, strlen($data));
        if ($result === false) {
            throw new SocketException(
                'socket_write() failed: '
                . socket_strerror(socket_last_error())
            );
        }
    }

    public function __destruct()
    {
        if (!is_null($this->socket)) {
            socket_close($this->socket);
        }
    }
}

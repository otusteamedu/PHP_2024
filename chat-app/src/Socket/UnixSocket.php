<?php

declare(strict_types=1);

namespace Sfadeev\ChatApp\Socket;

use RuntimeException;
use Socket;

class UnixSocket
{
    private Socket $_socket;
    private string $_path;

    /**
     * @throws RuntimeException
     */
    public function __construct(string $path)
    {
        if (false === ($sock = socket_create(AF_UNIX, SOCK_DGRAM, 0))) {
            throw new RuntimeException('socket_create()failed: reason: ' . socket_strerror(socket_last_error()));
        }

        $this->_socket = $sock;
        $this->_path = $path;
    }

    /**
     * @return void
     *
     * @throws RuntimeException
     */
    public function bind(): void
    {
        $directory = dirname($this->_path);

        if (!file_exists($directory)) {
            mkdir($directory);
        }

        if (false === socket_bind($this->_socket, $this->_path)) {
            throw new RuntimeException('ocket_bind(): failed: reason: ' . socket_strerror(socket_last_error()));
        }
    }

    /**
     * @param int $length
     * @return string
     *
     * @throws RuntimeException
     */
    public function read(int $length): string
    {
        if (false === ($data = socket_read($this->_socket, $length))) {
            $this->close();
            throw new RuntimeException('socket_read() failed: reason: ' . socket_strerror(socket_last_error()));
        }

        return $data;
    }

    /**
     * @param string $msg
     * @return void
     *
     * @throws RuntimeException
     */
    public function send(string $msg): void
    {
        if (socket_sendto($this->_socket, $msg, strlen($msg), 0, $this->_path) === false) {
            $this->close();
            throw new RuntimeException('socket_sendto() failed: reason: ' . socket_strerror(socket_last_error()));
        }
    }

    /**
     * @return void
     */
    public function close(): void
    {
        socket_close($this->_socket);
        unlink($this->_path);
    }
}

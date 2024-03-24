<?php

namespace IraYu\Service;

class UnixSocket
{
    private \Socket $socket;
    private ?string $socketPath = null;

    public function __construct(?\Socket $socket = null)
    {
        if (
            $socket === null
            && false === ($socket = socket_create(AF_UNIX, SOCK_STREAM, 0))
        ) {
            $this->throwLastError('Socket has not been created');
        }

        $this->socket = $socket;
    }

    private function throwLastError(string $message): string
    {
        $this->close();

        throw new \Exception($message . ': ' . socket_strerror(socket_last_error()));
    }

    public function bind(string $path): static
    {
        if (!socket_bind($this->socket, $path)) {
            $this->throwLastError('Socket has not been bound');
        }

        $this->socketPath = $path;

        return $this;
    }

    public function listen(): static
    {
        if (!socket_listen($this->socket)) {
            $this->throwLastError('Socket can not be listened');
        }

        socket_set_nonblock($this->socket);

        return $this;
    }

    public function connect(string $path): void
    {
        if (false === socket_connect($this->socket, $path)) {
            $this->throwLastError('Socket has not been connected');
        }
    }

    public function accept(): ?UnixSocket
    {
        if (false === ($newSocket = socket_accept($this->socket))) {
            $error = socket_last_error($this->socket);
            if ($error > 0 && $error !== SOCKET_EAGAIN && $error !== SOCKET_EWOULDBLOCK) {
                $this->throwLastError('Socket was not accepted');
            }

            return null;
        }

        return new UnixSocket($newSocket);
    }

    public function write(string $msg): static
    {
        $msg = trim($msg) . PHP_EOL;
        if (false === socket_write($this->socket, $msg, strlen($msg))) {
            $this->throwLastError('Socket was not written');
        }

        return $this;
    }

    public function recv(): ?string
    {
        $clientMessage = '';
        try {
            while (socket_recv($this->socket, $data, 2048, MSG_DONTWAIT) > 0) {
                $clientMessage .= $data;
            }
        } catch (\Throwable $e) {
            $clientMessage = null;
            $error = socket_last_error();
            if ($error > 0 && $error !== SOCKET_EAGAIN && $error !== SOCKET_EWOULDBLOCK) {
                $this->close();
            }
        }

        return $clientMessage;
    }

    public function read(): string
    {
        try {
            $clientMessage = socket_read($this->socket, 2048, PHP_NORMAL_READ);
        } catch (\Throwable $e) {
            $this->close();
            $this->throwLastError('Server can not be read');
        }

        return trim($clientMessage);
    }


    public function close(): void
    {
        if ($this->socketPath) {
            unlink($this->socketPath);
        }
        socket_close($this->socket);
    }
}

<?php

declare(strict_types=1);

namespace AlexanderGladkov\SocketChat\Socket;

use Socket;

class ClientSocket
{
    private SocketService $socketService;
    private Socket $socket;

    public function __construct(string $socketPath)
    {
        $this->socketService = new SocketService();
        $this->socket = $this->socketService->create();
        $this->socketService->connect($this->socket, $socketPath);
    }

    public function release(): void
    {
        $this->socketService->close($this->socket);
    }

    public function write(string $message): void
    {
        $this->socketService->write($this->socket, $message);
    }

    public function read(int $maxMessageLength): string
    {
        return $this->socketService->read($this->socket, $maxMessageLength);
    }
}

<?php

declare(strict_types=1);

namespace AlexanderGladkov\SocketChat\Socket;

use Socket;

class ServerSocket
{
    private SocketService $socketService;
    private Socket $socket;
    private Socket $connection;

    public function __construct(string $socketPath)
    {
        $this->deleteSocketFile($socketPath);
        $this->socketService = new SocketService();
        $this->socket = $this->socketService->create();
        $this->socketService->bind($this->socket, $socketPath);
        $this->socketService->listen($this->socket);
        $this->connection = $this->socketService->acceptConnection($this->socket);
    }

    public function release(): void
    {
        $this->socketService->close($this->connection);
        $this->socketService->close($this->socket);
    }

    public function write(string $message): void
    {
        $this->socketService->write($this->connection, $message);
    }

    public function read(int $maxMessageLength): string
    {
        return $this->socketService->read($this->connection, $maxMessageLength);
    }

    private function deleteSocketFile(string $socketPath): void
    {
        if (file_exists($socketPath)) {
            unlink($socketPath);
        }
    }
}

<?php

declare(strict_types=1);

namespace TBublikova\Php2024;

use TBublikova\Php2024\config\SocketConfig;

final class ChatApp
{
    private string $side;
    private string $socketPath;

    public function __construct()
    {
        $this->validateArguments();
        $this->initializeSocket();
    }

    private function validateArguments(): void
    {
        $args = $_SERVER['argv'] ?? [];
        if (count($args) !== 2 || !in_array($args[1], ['server', 'client'])) {
            throw new \RuntimeException('Incorrect arguments. Use: php app.php [server|client]');
        }
        $this->side = $args[1];
    }

    private function initializeSocket(): void
    {
        $config = new SocketConfig();
        $this->socketPath = $config->socketPath;
    }

    public function run(): void
    {
        $socket = new Socket($this->socketPath);
        $chat = match ($this->side) {
            'server' => new ServerChat($socket),
            'client' => new ClientChat($socket),
            default => throw new \Exception('Invalid arg. Use "server" or "client".'),
        };

        $chat->run();
    }
}

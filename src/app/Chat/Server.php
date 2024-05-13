<?php

declare(strict_types=1);

namespace App\Chat;

use App\Config\SocketConfig;
use App\Interfaces\Chat\AdapterInterface;
use App\Network\SocketManager;
use Generator;
use Socket;

readonly class Server implements AdapterInterface
{
    public function __construct(
        private SocketManager $socketManager,
        private SocketConfig $socketConfig,
    ) {}

    public function run(): Generator
    {
        $socket = $this->socketManager->create();

        $socketPath = $this->socketConfig->getPath();

        $this->socketManager->delete($socketPath);
        $this->socketManager->bind($socket, $socketPath);
        $this->socketManager->listen($socket);

        yield 'Server is up and running...' . PHP_EOL;
        yield from $this->handleConnections($socket);
    }

    private function handleConnections(Socket $socket): Generator
    {
        while (true) {
            $connection = $this->socketManager->accept($socket);

            yield from $this->handleConnection($connection);
        }
    }

    private function handleConnection(Socket $connection): Generator
    {
        yield 'New connection' . PHP_EOL;

        while (true) {
            $input = $this->socketManager->read($connection, $this->socketConfig->getMaxLength());

            if (trim($input) === 'exit') {
                yield 'Close connection request received' . PHP_EOL;

                $this->socketManager->close($connection);

                return;
            }

            yield 'Message received: ' . trim($input) . PHP_EOL;

            $confirmation = "Received " . strlen($input) . " bytes";

            $this->socketManager->write($connection, $confirmation);
        }
    }
}

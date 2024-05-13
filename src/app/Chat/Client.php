<?php

declare(strict_types=1);

namespace App\Chat;

use App\Config\SocketConfig;
use App\Interfaces\Chat\AdapterInterface;
use App\Network\SocketManager;
use Generator;
use Socket;

readonly class Client implements AdapterInterface
{
    public function __construct(
        private SocketManager $socketManager,
        private SocketConfig $socketConfig,
    ) {}

    public function run(): Generator
    {
        $socket = $this->socketManager->create();

        $this->socketManager->connect($socket, $this->socketConfig->getPath());

        yield 'Connection is established' . PHP_EOL;
        yield from $this->handleMessages($socket);
    }

    private function handleMessages(Socket $socket): Generator
    {
        while (true) {
            $input = readline('Enter a message (to quit please enter "exit"): ');

            if (empty($input)) {
                continue;
            }

            $this->socketManager->write($socket, $input);

            if (trim($input) === 'exit') {
                yield 'Closing connection...' . PHP_EOL;

                break;
            }

            yield 'Message has been successfully sent' . PHP_EOL;

            $confirmation = $this->socketManager->read($socket, $this->socketConfig->getMaxLength());

            yield 'Server response: ' . trim($confirmation) . PHP_EOL;
        }
    }
}
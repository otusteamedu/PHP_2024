<?php

declare(strict_types=1);

namespace AlexanderGladkov\SocketChat\Server;

use AlexanderGladkov\SocketChat\Config\Config;
use AlexanderGladkov\SocketChat\Socket\ServerSocket;
use Generator;

class Server
{
    public function __construct(private Config $config)
    {
    }

    /**
     * @return Generator<string>
     */
    public function run(): Generator
    {
        yield 'Server started' . PHP_EOL;
        $serverSocket = new ServerSocket($this->config->getSocketPath());
        while (true) {
            $message = $serverSocket->read($this->config->getMessageMaxLength());
            $messageLength = strlen($message);
            $serverSocket->write("Получено $messageLength байт от клиента");
            yield $message . PHP_EOL;
            if ($message === $this->config->getStopWord()) {
                break;
            }
        }

        $serverSocket->release();
        yield 'Server stopped' . PHP_EOL;
    }
}

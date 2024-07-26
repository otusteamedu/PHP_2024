<?php

declare(strict_types=1);

namespace AlexanderGladkov\SocketChat\Client;

use AlexanderGladkov\SocketChat\Config\Config;
use AlexanderGladkov\SocketChat\Socket\ClientSocket;
use Generator;

class Client
{
    public function __construct(private Config $config)
    {
    }

    /**
     * @return Generator<string>
     */
    public function run(): Generator
    {
        yield 'Client started' . PHP_EOL;
        $clientSocket = new ClientSocket($this->config->getSocketPath());
        while (true) {
            $message = readline('Сообщение: ');
            $clientSocket->write($message);
            $answer = $clientSocket->read($this->config->getMessageMaxLength());
            yield $answer . PHP_EOL;
            if ($message === $this->config->getStopWord()) {
                break;
            }
        }

        $clientSocket->release();
        yield 'Client stopped' . PHP_EOL;
    }
}

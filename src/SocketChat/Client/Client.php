<?php

declare(strict_types=1);

namespace AlexanderGladkov\SocketChat\Client;

use AlexanderGladkov\SocketChat\Config\Config;
use AlexanderGladkov\SocketChat\Socket\ClientSocket;

class Client
{
    public function __construct(private Config $config)
    {
    }

    public function run(): void
    {
        echo 'Client started' . PHP_EOL;
        $clientSocket = new ClientSocket($this->config->getSocketPath());
        while (true) {
            $message = readline('Сообщение: ');
            $clientSocket->write($message);
            $answer = $clientSocket->read($this->config->getMessageMaxLength());
            echo $answer . PHP_EOL;
            if ($message === $this->config->getStopWord()) {
                break;
            }
        }

        $clientSocket->release();
        echo 'Client stopped' . PHP_EOL;
    }
}

<?php

declare(strict_types=1);

namespace AlexanderGladkov\SocketChat\Server;

use AlexanderGladkov\SocketChat\Config\Config;
use AlexanderGladkov\SocketChat\Socket\ServerSocket;

class Server
{
    public function __construct(private Config $config)
    {
    }

    public function run(): void
    {
        echo 'Server started' . PHP_EOL;
        $serverSocket = new ServerSocket($this->config->getSocketPath());
        while (true) {
            $message = $serverSocket->read($this->config->getMessageMaxLength());
            $messageLength = strlen($message);
            $serverSocket->write("Получено $messageLength байт от клиента");
            echo $message. PHP_EOL;
            if ($message === $this->config->getStopWord()) {
                break;
            }
        }

        $serverSocket->release();
        echo 'Server stopped' . PHP_EOL;
    }
}

<?php

namespace Naimushina\Chat;

use Exception;

class Server
{
    /**
     * @var Socket
     */
    private Socket $socket;

    /**
     * @var ConfigManager
     */
    private mixed $configManager;

    public function __construct(Socket $socket, $configManager)
    {
        $this->socket = $socket;
        $this->configManager = $configManager;
    }

    /**
     * @throws Exception
     */
    public function run(): void
    {
        $file = $this->configManager->get('socket_file');

        $this->socket->clear($file);
        $this->socket->create();
        $this->socket->bind($file);
        $this->socket->listen($this->configManager->get('socket_max_connection'));
        $connectionSocket = $this->socket->accept();

        echo 'ready to receive' . PHP_EOL;

        do {
            [$message, $length] = $this->socket->receive($connectionSocket);
            $message = trim($message);
            if ($message) {
                echo 'Received message: ' . $message . PHP_EOL;
                if ($message == 'exit') {
                    break;
                }
                $this->socket->write($connectionSocket, "Received $length bytes");

            }

        } while (true);
        $this->socket->close($this->socket->unixSocket);
    }

}

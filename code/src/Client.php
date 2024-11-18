<?php

namespace Naimushina\Chat;

class Client
{
    /**
     * @var Socket
     */
    private Socket $socket;
    /**
     * @var ConfigManager
     */
    private mixed $configManager;

    /**
     * @param Socket $socket
     * @param ConfigManager $configManager
     */
    public function __construct(Socket $socket, ConfigManager $configManager)
    {
        $this->socket = $socket;
        $this->configManager = $configManager;
    }

    /**
     * @throws \Exception
     */
    public function run(): void
    {
        $this->socket->create();
        $this->socket->connect($this->configManager->get('socket_file'));

        while (true) {
            echo 'Input message' . PHP_EOL;

            $message = $this->getInput();
            $this->socket->write($this->socket->unixSocket, $message);

            $confirmation = $this->socket->read(
                $this->socket->unixSocket,
                $this->configManager->get('socket_length')
            );

            if (trim($message) === 'exit') {
                break;
            } else {
                echo 'Server confirmed: ' . $confirmation . PHP_EOL;
            }
        }
        $this->socket->close($this->socket->unixSocket);
    }

    public function getInput(): bool|string
    {
        return fgets(STDIN);
    }
}

<?php

namespace AKornienko\hw5;

class Server
{
    private SocketWrapper $socketWrapper;
    private \Generator $printer;

    /**
     * @throws \Exception
     */
    public function __construct(string $socketPath)
    {
        $this->socketWrapper = new SocketWrapper($socketPath);
        $this->socketWrapper->bind();
    }

    /**
     * @throws \Exception
     */
    public function run(): \Generator
    {
        return $this->listenSocketConnections();
    }

    private function listenSocketConnections(): \Generator
    {
        $this->socketWrapper->listen();

        while (true) {
            $clientSocket = $this->socketWrapper->accept();
            while (true) {
                $message = $this->socketWrapper->read($clientSocket);

                if (!$message) {
                    break;
                }
                $receivedMessage = "Received message: $message";
                yield $receivedMessage;
                $this->sendConfirmationMessage($clientSocket, $message);
            }
        }
    }

    /**
     * @throws \Exception
     */
    private function sendConfirmationMessage(\Socket $socket, string $receivedMessage): void
    {
        $byte = strlen($receivedMessage);
        $backMessage = "Received $byte bytes";
        $this->socketWrapper->write($socket, $backMessage);
    }
}

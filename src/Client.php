<?php

namespace AKornienko\hw5;

class Client
{
    private SocketWrapper $socketWrapper;

    /**
     * @throws \Exception
     */
    public function __construct(string $socketPath)
    {
        $this->socketWrapper = new SocketWrapper($socketPath);
        $this->socketWrapper->connect();
    }

    public function run(): \Generator
    {
        return $this->listenStdin();
    }

    private function listenStdin(): \Generator
    {
        while (true) {
            $message = $this->getStdinMessage();

            if (!$message) {
                continue;
            }

            yield $this->sendMessage($message);
        }
    }

    private function getStdinMessage(): string
    {
        return trim(readline("Write something: "));
    }

    /**
     * @param string $message
     * @return string
     * @throws \Exception
     */
    private function sendMessage(string $message): string
    {
        $serverSocket = $this->socketWrapper->getSocket();
        $this->socketWrapper->write($serverSocket, $message);
        return $this->socketWrapper->read($serverSocket);
    }
}

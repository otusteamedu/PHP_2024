<?php

namespace TBublikova\Php2024;

class ClientChat
{
    private $clientSocket;

    public function __construct(private Socket $socket)
    {
    }

    public function run(): void
    {
        $this->connectToServer();

        while (true) {
            $message = readline('Enter a message (or `stop` to exit): ');

            if ($message === 'stop') {
                break;
            }

            $this->sendMessage($message);
            $this->receiveResponse();
        }

        $this->closeConnection();
    }

    private function connectToServer(): void
    {
        $this->socket->connect();
        $this->clientSocket = $this->socket->getSocket();
        echo "Connected to server\n";
    }

    private function sendMessage(string $msg): void
    {
        $bytesSent = $this->socket->send($this->clientSocket, $msg);
        if ($bytesSent === -1) {
            throw new \RuntimeException('Failed to send message to server');
        }
        echo "Message sent to server: $msg\n";
    }

    private function receiveResponse(): void
    {
        $response = '';
        $bytesReceived = $this->socket->receive($this->clientSocket, $response);
        if ($bytesReceived === -1) {
            throw new \RuntimeException('Failed to receive response from server');
        }
        echo "Received response from server: $response\n";
    }

    private function closeConnection(): void
    {
        $this->socket->close($this->clientSocket);
        echo "Connection closed\n";
    }
}

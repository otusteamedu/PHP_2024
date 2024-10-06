<?php

namespace TBublikova\Php2024;

class ServerChat
{
    private bool $stop = false;

    public function __construct(private Socket $socket)
    {
        $this->socket->bindAndListen();
    }

    public function stop(): void
    {
        $this->stop = true;
    }

    public function run(): void
    {
        while (!$this->stop) {
            echo "Ready to receive...\n";

            $clientSocket = $this->socket->accept();
            while (true) {
                $buf = '';

                $bytes_received = $this->socket->receive($clientSocket, $buf);
                if ($bytes_received === 0) {
                    echo "Client disconnected\n";
                    break;
                }
                if ($bytes_received === -1) {
                    echo "An error occurred while receiving from the socket\n";
                    break;
                }

                echo "Received $buf\n";

                $buf .= "->Response";

                $bytes_sent = $this->socket->send($clientSocket, $buf);
                if ($bytes_sent === -1) {
                    echo "An error occurred while sending to the socket\n";
                    break;
                }

                if ($bytes_sent !== strlen($buf)) {
                    echo $bytes_sent . ' bytes have been sent instead of the ' . strlen($buf) . ' bytes expected' . "\n";
                    break;
                }

                echo "Request processed\n";
            }

            $this->socket->close($clientSocket);
        }
    }
}

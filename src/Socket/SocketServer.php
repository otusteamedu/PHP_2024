<?php

declare(strict_types=1);

namespace RailMukhametshin\Hw\Socket;

use Exception;
use RailMukhametshin\Hw\Formatters\ConsoleOutputFormatter;
use Socket;

class SocketServer extends AbstractSocket
{
    private function bindSock(): void
    {
        @unlink($this->socketPath);

        if (socket_bind($this->sock, $this->socketPath) === false) {
            throw new Exception("Socket binding error: " . socket_strerror(socket_last_error($this->sock)));
        }
    }

    /**
     * @throws Exception
     */
    private function startListening(): void
    {
        $this->createSock();
        $this->bindSock();

        if (socket_listen($this->sock, 5) === false) {
            throw new Exception("Socket listening error: " . socket_strerror(socket_last_error($this->sock)));
        }
    }

    private function acceptConnection(): Socket
    {
        if (($clientSock = socket_accept($this->sock)) === false) {
            throw new Exception("Socket accepting error: " . socket_strerror(socket_last_error($this->sock)));
        }

        socket_set_nonblock($clientSock);

        return $clientSock;
    }

    /**
     * @throws Exception
     */
    public function start(): void
    {
        $this->startListening();

        try {
            do {
                $clientSock = $this->acceptConnection();

                if ($clientSock) {
                    $this->formatter->output('Client connected');
                    $this->write($clientSock, "Welcome to Socket Server!");

                    while (true) {
                        $buf = $this->read($clientSock);

                        if (!$buf = trim($buf)) {
                            continue;
                        }

                        if ($buf == 'quiet') {
                            break;
                        }

                        $this->formatter->output(sprintf('Client sent: %s', $buf));
                        $this->write($clientSock, sprintf("Server received %s bytes", strlen($buf)));
                    }

                    $this->closeSocket($clientSock);
                    $this->formatter->output('Client disconnected');
                }
            } while (true);
        } catch (Exception $exception) {
            $this->formatter->output($exception->getMessage(), ConsoleOutputFormatter::COLOR_RED);
        }

        $this->closeSocket($this->sock);
    }
}

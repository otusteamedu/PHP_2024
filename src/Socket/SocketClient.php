<?php

declare(strict_types=1);

namespace RailMukhametshin\Hw\Socket;

use Exception;
use RailMukhametshin\Hw\Formatters\ConsoleOutputFormatter;

class SocketClient extends AbstractSocket
{
    /**
     * @throws Exception
     */
    private function connect(): void
    {
        $this->createSock();

        if (socket_connect($this->sock, $this->socketPath) === false) {
            throw new Exception("Error connecting to server: " . socket_strerror(socket_last_error($this->sock)));
        }

        socket_set_nonblock($this->sock);
    }

    public function start(): void
    {
        try {
            $this->connect();
            while (true) {
                while ($out = $this->read($this->sock)) {
                    $this->formatter->output($out);

                    $message = fgets(STDIN);

                    if ($message) {
                        $this->write($this->sock, $message);
                    }
                }
            }
        } catch (Exception $exception) {
            $this->formatter->output($exception->getMessage(), ConsoleOutputFormatter::COLOR_RED);
        }

        $this->disconnect();
    }

    private function disconnect(): void
    {
        $this->closeSocket($this->sock);
    }
}

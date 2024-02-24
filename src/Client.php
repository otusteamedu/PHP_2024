<?php

declare(strict_types=1);

namespace AShutov\Hw5;

use Exception;
class Client
{
    private Socket $socket;

    /**
     * @throws Exception
     */
    public function __construct(Socket $socket)
    {
        $this->socket = $socket;
        $this->socket->connect();
    }

    /**
     * @throws Exception
     */
    public function start(): void
    {
        while (true) {
            $message = readline('Введите сообщение(для выхода введите bye): ');
            $this->socket->write($this->socket->socket, $message);

            if ($message === 'bye') {
                break;
            }
            $answer = $this->socket->read($this->socket->socket);
            echo $answer . PHP_EOL;
        }
        $this->socket->close();
    }
}

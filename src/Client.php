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
            $this->socket->write($message);

            if ($message === 'bye') {
                break;
            }
        }

        $this->socket->close();
    }
}
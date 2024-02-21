<?php

declare(strict_types=1);

namespace Afilippov\Hw5;

use Exception;

class Client
{
    private Socket $socket;

    private bool $isRunning = true;

    /**
     * @throws Exception
     */
    public function __construct(Socket $socket)
    {
        $this->socket = $socket;

        $this->socket->create();

        $this->socket->connect();
    }

    /**
     * @throws Exception
     */
    public function start(): void
    {
        while ($this->isRunning) {
            $message = readline('Введите сообщение: ');
            $this->socket->write($message);

            if ($message === 'STOP') {
                $this->isRunning = false;
            }
        }

        $this->socket->close();
    }
}

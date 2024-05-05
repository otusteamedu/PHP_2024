<?php

declare(strict_types=1);

namespace JuliaZhigareva\OtusComposerPackage;

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

        $this->socket->create();

        $this->socket->connect();
    }

    /**
     * @throws Exception
     */
    public function start(): void
    {
        while (true) {
            $message = readline('Введите сообщение: ');
            $this->socket->write($message);

            if ($message === 'STOP') {
                break;
            }
        }

        $this->socket->close();
    }
}

<?php

declare(strict_types=1);

namespace Otus\SocketChat;

use Exception;

class Client implements Socketable
{
    public function __construct(private readonly Socket $socket)
    {
    }

    /**
     * @throws Exception
     */
    public function start(): void
    {
        $this->socket->connect();

        while (true) {
            $message = readline('Ваше сообщение: ');
            if (!$message) {
                continue;
            }

            $this->socket->send($message);

            $data = $this->socket->read();
            if ($data) {
                echo 'Ответ: ' . $data . PHP_EOL;
            }

            if ($message === '/exit') {
                break;
            }
        }

        $this->socket->close();
    }
}

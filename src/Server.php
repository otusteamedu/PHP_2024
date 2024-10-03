<?php

declare(strict_types=1);

namespace Otus\SocketChat;

use Exception;

class Server implements Socketable
{

    public function __construct(private readonly Socket $socket)
    {
    }

    /**
     * @throws Exception
     */
    public function start(): void
    {
        $this->socket->bind();
        $this->socket->listen();

        echo "Сервер активен" . PHP_EOL;

        $accept = $this->socket->accept();

        while (true) {
            $data = $this->socket->read($accept);
            if (!$data) {
                continue;
            }

            echo 'Полученное сообщение: ' . $data . PHP_EOL;
            $this->socket->send(mb_strlen($data, '8bit') . 'байт получено.', $accept);

            if ($data === '/exit') {
                echo "Сервер отключен" . PHP_EOL;
                break;
            }
        }

        $this->socket->close();
    }
}

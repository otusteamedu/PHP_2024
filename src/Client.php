<?php

declare(strict_types=1);

namespace hw5;

use hw5\interfaces\LogInterface;
use hw5\interfaces\ClientServerInterface;
use hw5\interfaces\SocketInterface;

class Client implements ClientServerInterface
{
    public function __construct(
        private SocketInterface $socket,
        private LogInterface $log
    ) {
    }

    public function process(): void
    {
        $this->log->info("Старт клиента");

        $socket = $this->socket->create();
        $this->socket->connect($socket);

        while (true) {
            $message = readline('Введите сообщение и нажмите Enter: ');
            $this->socket->write($socket, $message);
            if ($message === 'quit') {
                $this->log->info("Соединение с сервером разоравно");
                sleep(5);
                break;
            }

            $messageServer = $this->socket->read($socket);
            $this->log->info("Ответ сервера: $messageServer");
            sleep(5);
        }
        $this->socket->close($socket);
    }
}

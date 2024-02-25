<?php

declare(strict_types=1);

namespace hw5;

use hw5\interfaces\UnixSocetInterface;

class Client implements UnixSocetInterface
{
    public function __construct(
        private UnixSocket $socket
    ){}

    public function process():void
    {
        echo "Старт клиента" . PHP_EOL;

        $socket = $this->socket->create();
        $this->socket->connect($socket);

        while (true) {
            $message = readline('Введите сообщение и нажмите Enter: ');
            $this->socket->write($socket, $message);
            if ($message === 'quit') {
                echo "Соединение с сервером разоравно" .PHP_EOL;
                break;
            }

            $messageServer = $this->socket->read($socket);
            echo "Ответ сервера: $messageServer" .PHP_EOL;
            sleep(5);

        }
        $this->socket->close($socket);
    }
}

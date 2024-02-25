<?php

declare(strict_types=1);

namespace hw5;

use hw5\interfaces\UnixSocetInterface;

class Server implements UnixSocetInterface
{
    public function __construct(
        private UnixSocket $socket
    ) {
    }

    public function process(): void
    {
        $socket = $this->socket->create();
        $this->socket->bind($socket);
        $this->socket->listen($socket);

        echo "Старт сервера" . PHP_EOL;

        while (true) {
            $client = $this->socket->acceptClient($socket);
            $clientMessage = $this->socket->read($client);

            if($clientMessage == 'quit') {
                echo "Клиент отключился от сервера" . PHP_EOL;
                $this->socket->closeClient($client);
                break;
            }

            if (!empty($clientMessage)) {
                echo "Сообщение с клиента" . PHP_EOL;
                echo $clientMessage . PHP_EOL;
            }

            $this->socket->write($client, "Прочитано");
        }
        echo "Отключение сервера" . PHP_EOL;
        $this->socket->close($socket);
    }
}

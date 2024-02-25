<?php

declare(strict_types=1);

namespace hw5;

use hw5\interfaces\LogInterface;
use hw5\interfaces\ClientServerInterface;
use hw5\interfaces\SocketInterface;

class Server implements ClientServerInterface
{
    public function __construct(
        private SocketInterface $socket,
        private LogInterface $log
    ) {
    }

    public function process(): void
    {
        $socket = $this->socket->create();
        $this->socket->bind($socket);
        $this->socket->listen($socket);

        $this->log->info("Старт сервера");

        while (true) {
            $client = $this->socket->acceptClient($socket);
            $clientMessage = $this->socket->read($client);

            if($clientMessage === 'quit') {
                $this->log->info("Клиент отключился от сервера" . PHP_EOL);
                $this->socket->closeClient($client);
                break;
            }

            if (!empty($clientMessage)) {
                $this->log->info("Сообщение с клиента");
                $this->log->info($clientMessage);
            }

            $this->socket->write($client, "Прочитано");
        }
        $this->log->info("Отключение сервера");
        $this->socket->close($socket);
    }
}

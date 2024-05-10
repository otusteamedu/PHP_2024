<?php

declare(strict_types=1);

namespace ABuynovskiy\Hw5;

use Generator;
use RuntimeException;

class Client
{
    private SocketHandler $socketHandler;

    public function __construct()
    {
        $this->socketHandler = new SocketHandler();
    }

    /**
     * @return Generator<string>
     */
    public function run(): Generator
    {
        $socketPath = $this->socketHandler->getSocketPath();

        $clientSocket = $this->socketHandler->createSocket();
        if (!$clientSocket) {
            throw new RuntimeException("При создании сокета возникла ошибка: " . socket_strerror(socket_last_error()));
        }

        try {
            if (!$this->socketHandler->connectSocket($clientSocket, $socketPath)) {
                throw new RuntimeException(
                    "При подключении к серверу возникла ошибка: " . socket_strerror(socket_last_error())
                );
            }

            yield "Подключение к серверу установлено." . PHP_EOL;

            while (true) {
                $input = readline("Введите сообщение для отправки серверу (для выхода введите 'exit'): ");
                if (!empty($input)) {
                    if (!$this->socketHandler->writeSocket($clientSocket, $input)) {
                        throw new RuntimeException(
                            "Ошибка при отправке данных серверу: " . socket_strerror(socket_last_error())
                        );
                    }

                    if (trim($input) === 'exit') {
                        yield "Отключение от сервера..." . PHP_EOL;
                        break;
                    }

                    $confirmation = $this->socketHandler->readSocket($clientSocket);
                    if (!$confirmation) {
                        throw new RuntimeException(
                            "При чтении данных возникла ошибка: " . socket_strerror(socket_last_error())
                        );
                    }

                    yield "От сервера получено: " . trim($confirmation) . PHP_EOL;
                }
            }
        } finally {
            $this->socketHandler->closeSocket($clientSocket);
        }
    }
}

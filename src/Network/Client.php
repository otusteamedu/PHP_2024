<?php

declare(strict_types=1);

namespace Dsmolyaninov\Hw5\Network;

class Client
{
    private SocketHandler $socketHandler;

    public function __construct()
    {
        $this->socketHandler = new SocketHandler();
    }

    public function run(): void
    {
        $socketPath = $this->socketHandler->getSocketPath();

        $clientSocket = $this->socketHandler->createSocket();
        if (!$clientSocket) {
            throw new \RuntimeException("Ошибка при создании сокета: " . socket_strerror(socket_last_error()));
        }

        try {
            if (!$this->socketHandler->connectSocket($clientSocket, $socketPath)) {
                throw new \RuntimeException(
                    "Ошибка при подключении к серверу: " . socket_strerror(socket_last_error())
                );
            }

            echo "Подключение к серверу установлено." . PHP_EOL;

            while (true) {
                $input = readline("Введите сообщение для отправки серверу (для выхода введите 'exit'): ");
                if (!empty($input)) {
                    if (!$this->socketHandler->writeSocket($clientSocket, $input)) {
                        throw new \RuntimeException(
                            "Ошибка при отправке данных серверу: " . socket_strerror(socket_last_error())
                        );
                    }

                    if (trim($input) === 'exit') {
                        echo "Отключение от сервера..." . PHP_EOL;
                        break;
                    }

                    $confirmation = $this->socketHandler->readSocket($clientSocket);
                    if (!$confirmation) {
                        throw new \RuntimeException(
                            "Ошибка при чтении данных: " . socket_strerror(socket_last_error())
                        );
                    }

                    echo "От сервера получено: " . trim($confirmation) . PHP_EOL;
                }
            }
        } finally {
            $this->socketHandler->closeSocket($clientSocket);
        }
    }
}

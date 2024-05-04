<?php

declare(strict_types=1);

namespace Dsmolyaninov\Hw5\Network;

use Socket;

class Server
{
    private SocketHandler $socketHandler;

    public function __construct()
    {
        $this->socketHandler = new SocketHandler();
    }

    public function run(): void
    {
        $socketPath = $this->socketHandler->getSocketPath();
        self::removeExistingSocket($socketPath);

        $serverSocket = $this->socketHandler->createSocket();
        if (!$serverSocket) {
            throw new \RuntimeException("Ошибка при создании сокета: " . socket_strerror(socket_last_error()));
        }

        if (!$this->socketHandler->bindSocket($serverSocket, $socketPath)) {
            throw new \RuntimeException("Ошибка при привязке сокета к адресу: " . socket_strerror(socket_last_error()));
        }

        if (!$this->socketHandler->listenSocket($serverSocket)) {
            throw new \RuntimeException(
                "Ошибка при начале прослушивания сокета: " . socket_strerror(socket_last_error())
            );
        }

        echo "Сервер запущен и ожидает соединений..." . PHP_EOL;
        $this->handleConnections($serverSocket);
    }

    private function handleConnections(Socket $serverSocket): void
    {
        while (true) {
            $clientSocket = $this->socketHandler->acceptSocket($serverSocket);
            if (!$clientSocket) {
                throw new \RuntimeException("Ошибка при принятии соединения: " . socket_strerror(socket_last_error()));
            }
            $this->processClient($clientSocket);
        }
    }

    private function processClient(Socket $clientSocket): void
    {
        $pid = pcntl_fork();
        if ($pid == -1) {
            throw new \RuntimeException("Ошибка при создании потока (процесса)");
        } elseif ($pid === 0) {
            $this->handleClient($clientSocket);
        } else {
            $this->socketHandler->closeSocket($clientSocket);
        }
    }

    private function handleClient(Socket $clientSocket): void
    {
        echo "Клиент подключен." . PHP_EOL;
        while (true) {
            $input = socket_read($clientSocket, 1024);
            if ($input === false) {
                throw new \RuntimeException("Ошибка при чтении данных: " . socket_strerror(socket_last_error()));
            }
            if (trim($input) === 'exit') {
                echo "Клиент запросил закрытие соединения." . PHP_EOL;
                $this->socketHandler->closeSocket($clientSocket);
                exit();
            }
            echo "Получено от клиента: " . trim($input) . PHP_EOL;
            $confirmation = "Received " . strlen($input) . " bytes";
            if (!socket_write($clientSocket, $confirmation, strlen($confirmation))) {
                throw new \RuntimeException(
                    "Ошибка при отправке данных клиенту: " . socket_strerror(socket_last_error())
                );
            }
        }
    }

    private function removeExistingSocket(string $socketPath): void
    {
        if (file_exists($socketPath)) {
            unlink($socketPath);
        }
    }
}

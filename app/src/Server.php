<?php

declare(strict_types=1);

namespace ABuynovskiy\Hw5;

use Generator;
use RuntimeException;
use Socket;

class Server
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
        self::removeExistingSocket($socketPath);

        $serverSocket = $this->socketHandler->createSocket();
        if (!$serverSocket) {
            throw new RuntimeException("ПРи создании сокета возникла ошибка: " . socket_strerror(socket_last_error()));
        }

        if (!$this->socketHandler->bindSocket($serverSocket, $socketPath)) {
            throw new RuntimeException("При привязке сокета к адресу возникла ошибка: " . socket_strerror(socket_last_error()));
        }

        if (!$this->socketHandler->listenSocket($serverSocket)) {
            throw new RuntimeException(
                "При начале прослушивания сокета возникла ошибка: " . socket_strerror(socket_last_error())
            );
        }

        yield "Сервер запущен и ожидает соединений..." . PHP_EOL;
        yield from $this->handleConnections($serverSocket);
    }

    /**
     * @return Generator<string>
     */
    private function handleConnections(Socket $serverSocket): Generator
    {
        while (true) {
            $clientSocket = $this->socketHandler->acceptSocket($serverSocket);
            if (!$clientSocket) {
                throw new RuntimeException("При принятии соединения возникла ошибка: " . socket_strerror(socket_last_error()));
            }
            yield from $this->processClient($clientSocket);
        }
    }

    /**
     * @return Generator<string>
     */
    private function processClient(Socket $clientSocket): Generator
    {
        $pid = pcntl_fork();
        if ($pid == -1) {
            throw new RuntimeException("Ошибка при создании потока (процесса)");
        } elseif ($pid === 0) {
            yield from $this->handleClient($clientSocket);
        } else {
            $this->socketHandler->closeSocket($clientSocket);
        }
    }

    /**
     * @return Generator<string>
     */
    private function handleClient(Socket $clientSocket): Generator
    {
        yield "Клиент подключен." . PHP_EOL;
        while (true) {
            $input = socket_read($clientSocket, 1024);
            if ($input === false) {
                throw new RuntimeException("При чтении данных возникла ошибка: " . socket_strerror(socket_last_error()));
            }
            if (trim($input) === 'exit') {
                yield "Клиент запросил закрытие соединения." . PHP_EOL;
                $this->socketHandler->closeSocket($clientSocket);
                return;
            }
            yield "Получено от клиента: " . trim($input) . PHP_EOL;
            $confirmation = "Received " . strlen($input) . " bytes";
            if (!socket_write($clientSocket, $confirmation, strlen($confirmation))) {
                throw new RuntimeException(
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

<?php

declare(strict_types=1);

namespace Main;

use http\Env;

class SocketServer
{
    public $socket = false;

    public $socketFile;

    public function __construct()
    {
        $this->initSocketFilePath();
        $this->socketCreate();
        $this->socketBind();
        $this->socketListen();
    }

    public function initSocketFilePath(): void
    {
        $path = __DIR__ . getenv('SOCKET_PATH');
        if (file_exists($path)) {
            if (is_dir($path)) {
                throw new \Exception('Не правильный путь к сокету');
            } else {
                unlink($path);
            }
        }
        $this->socketFile = $path;
    }

    public function socketCreate(): bool
    {
        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);

        if ($socket === false) {
            throw new \Exception("Не удалось выполнить socket_create(): причина: " . socket_last_error());

            return false;
        }

        $this->socket = $socket;

        return true;
    }

    public function socketBind(): bool
    {
        if (socket_bind($this->socket, $this->socketFile) === false) {
            throw new \Exception("Не удалось выполнить socket_bind(): причина: " . socket_last_error($this->socket));
        }

        return true;
    }

    public function socketListen(): bool
    {
        if (socket_listen($this->socket, 5) === false) {
            throw new \Exception("Не удалось выполнить socket_listen(): причина: " . socket_last_error($this->socket));
        }
        return true;
    }

    public function runListener(): \Generator
    {
        yield "Сервер ожидает подключение клиента." . PHP_EOL;
        foreach ($this->getClientSocket() as $clientSocket) {
            yield "Клиент подключился к серверу." . PHP_EOL;
            foreach ($this->runClientListener($clientSocket) as $message) {
                yield $message;
            }
            yield "Клиент отключился от сервера. Сервер ожидает подключение нового клиента" . PHP_EOL;
        }
    }

    public function runClientListener($clientSocket): \Generator
    {
        foreach ($this->getClientMessage($clientSocket) as $message) {
            yield "Сообщения от клиента: " . $message . PHP_EOL;
            $messageOut = "Получено байт:" . strlen($message);
            socket_write($clientSocket, $messageOut, strlen($messageOut));
        }
        socket_close($clientSocket);
    }

    public function getClientSocket(): \Generator
    {
        while (true) {
            if (($clientSocket = socket_accept($this->socket)) === false) {
                return;
            }
            yield $clientSocket;
        }
    }

    public function getClientMessage($clientSocket): \Generator
    {
        while (true) {
            $clientMessage = socket_read($clientSocket, 2048);
            if (empty($clientMessage)) {
                return;
            }
            yield $clientMessage;
        }
    }

    public function closeSocket(): void
    {
        socket_close($this->socket);
    }
}

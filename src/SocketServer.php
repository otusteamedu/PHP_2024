<?php

declare(strict_types=1);

namespace Main;

use http\Env;

class SocketServer
{
    public $socket = false;

    public $clientSocket = false;

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

    public function runListner(): void
    {
        do {
            echo "Сервер готов к прослушиванию." . PHP_EOL;

            if (($this->clientSocket = socket_accept($this->socket)) === false) {
                break;
            }

            do {
                $buf = socket_read($this->clientSocket, 2048);

                if ($buf === false) {
                    break;
                }

                $messageOut = "Получено байт:" . strlen($buf);

                if (socket_write($this->clientSocket, $messageOut, strlen($messageOut)) === false) {
                    break;
                }
            } while (true);
            socket_close($this->clientSocket);
        } while (true);
    }

    public function closeSocket(): void
    {
        socket_close($this->clientSocket);
        socket_close($this->socket);
    }
}

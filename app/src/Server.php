<?php

declare(strict_types=1);

namespace Dw\OtusSocketChat;

use Dw\OtusSocketChat\Application\BaseApplication;
use Exception;

class Server extends BaseApplication
{
    /**
     * @throws Exception
     */
    public function run(): void
    {
        if (file_exists($this->socketPath)) {
            unlink($this->socketPath);
        }

        if (!socket_bind($this->socket, $this->socketPath)) {
            throw new Exception('Ошибка привязки сокета: ' . socket_strerror(socket_last_error()));
        }

        if (!socket_listen($this->socket)) {
            throw new Exception("Ошибка при прослушивании сокета: " . socket_strerror(socket_last_error()));
        }

        while (true) {
            echo "Сервер: ожидание сообщений..." . PHP_EOL;

            $clientSocket = socket_accept($this->socket);
            if (!$clientSocket) {
                echo "Ошибка соединения на сокете: " . socket_strerror(socket_last_error()) . PHP_EOL;
                continue;
            }

            while (true) {
                $inputData = socket_read($clientSocket, $this->maxMessageLength);

                if ($inputData === false) {
                    echo "Ошибка при чтении данных: " . socket_strerror(socket_last_error()) . PHP_EOL;
                    break;
                }
                if ($inputData === '') {
                    echo "Клиент закрыл соединение." . PHP_EOL;
                    break;
                }

                echo "Получено сообщение: " . $inputData . PHP_EOL;

                $response = "получил " . strlen($inputData) . " байт";
                if (!socket_write($clientSocket, $response, strlen($response))) {
                    echo "Ошибка при отправке данных клиенту: " . socket_strerror(socket_last_error()) . PHP_EOL;
                }
            }
        }
    }
}

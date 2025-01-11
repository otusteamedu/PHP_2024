<?php

namespace Ekonyaeva\Otus;

use Exception;

class SocketServer
{
    private $socket;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->createSocket();
    }

    /**
     * @throws Exception
     */
    private function createSocket(): void
    {
        $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if ($this->socket === false) {
            throw new Exception("Не удалось создать сокет: " . socket_strerror(socket_last_error()));
        }
        socket_bind($this->socket, '0.0.0.0', 8000); // Слушаем на всех интерфейсах
        socket_listen($this->socket);

        echo "Сервер запущен. Ожидание подключения клиента...\n";

        $this->acceptConnections();

        socket_close($this->socket);
    }

    private function acceptConnections()
    {
        while (true) {
            $client = socket_accept($this->socket);
            if ($client === false) {
                echo "Ошибка при принятии соединения.\n";
                continue; // Если есть ошибка, переходим к следующему циклу
            }

            echo "Клиент подключился.\n";

            $this->handleClient($client);
        }
    }

    private function handleClient($client): void
    {
        while (true) {
            $input = socket_read($client, 1024);
            if ($input === false || $input === "") {
                echo "Клиент отключился.\n";
                break; // Выходим из цикла, если клиент отключился
            }

            echo "Получено сообщение от клиента: $input\n";
            echo "Введите сообщение для ответа (или 'exit' для выхода): ";
            $response = fgets(STDIN);
            $response = trim($response);

            socket_write($client, $response, strlen($response));
        }

        socket_close($client); // Закрываем сокет клиента после отключения
    }

    /**
     * @throws Exception
     */
    public function start(): void
    {
        $this->createSocket();
    }
}
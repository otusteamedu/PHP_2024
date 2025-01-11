<?php

namespace Ekonyaeva\Otus;

use Exception;

class SocketClient
{
    private $socket;

    /**
     * @throws Exception
     */
    public function __construct() {
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

        $result = socket_connect($this->socket, 'server', 8000); // Укажите адрес сервера и порт
        if ($result === false) {
            throw new Exception("Не удалось подключиться к серверу: " . socket_strerror(socket_last_error($this->socket)));
        }

        $this->communicate();
        socket_close($this->socket);
    }

    /**
     * @throws Exception
     */
    public function start(): void
    {
        $this->createSocket();
    }

    private function communicate()
    {
        while (true) {
            $this->sendMessage();
        }
    }

    public function sendMessage(): void
    {
        echo "Введите сообщение для отправки (или 'exit' для выхода): ";
        $input = fgets(STDIN);
        $input = trim($input);

        if ($input === 'exit') {
            echo "Выход из программы.\n";
            socket_close($this->socket);
            exit;
        }

        socket_write($this->socket, $input, strlen($input));

        $response = socket_read($this->socket, 1024);
        if ($response === false) {
            echo "Ошибка при чтении ответа от сервера. Пожалуйста, проверьте подключение.\n";
            return;
        }
        echo "Ответ от сервера: $response\n";
    }
}
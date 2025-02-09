<?php

declare(strict_types=1);

namespace Apeskovatzkov\Hw5;

use Apeskovatzkov\Hw5\Application\Configurator;
use Apeskovatzkov\Hw5\Contracts\RunnableInterface;
use Exception;
use Socket;

class Server implements RunnableInterface
{
    public function __construct(
        private readonly Configurator $configurator,
        private ?Socket $socket = null
    ) {
        echo 'Инициализация...' . PHP_EOL;
        $this->socket ??= $this->initSocket();
    }

    public function run(): void
    {
        echo 'Сервер слушает сообщения...' . PHP_EOL;

        while (true) {
            if (!socket_set_block($this->socket)) {
                throw new Exception('Не удалось перевести сокет в блокирующий режим: ' . socket_strerror(socket_last_error()));
            }
            $buffer = '';

            $bytesReceived = socket_recv($this->socket, $buffer, 1024, 0);
            if ($bytesReceived == -1) {
                throw new Exception('Произошла ошибка при чтении из сокета');
            }
            echo 'Получено сообщение: ' . '"' . trim($buffer) . '"' . PHP_EOL;

            if (!socket_set_nonblock($this->socket)) {
                throw new Exception('Не удалось перевести сокет в не блокирующий режим: ' . socket_strerror(socket_last_error()));
            }

            $response = "Получено $bytesReceived байт" . PHP_EOL;
            socket_sendto($this->socket, $response, strlen($response), 0, $this->configurator->getParam('client_socket_address'));
        }
    }

    private function initSocket(): Socket
    {
        echo 'Создаю сокет...' . PHP_EOL;
        if (!$socket = socket_create(AF_UNIX, SOCK_DGRAM, 0)) {
            throw new Exception('Не удалось создать сокет: ' . socket_strerror(socket_last_error()));
        }

        $this->deleteSocketFileIfExists();

        echo 'Привязываю сокет...' . PHP_EOL;
        if (!socket_bind($socket, $this->configurator->getParam('server_socket_address'))) {
            throw new Exception('Не удалось привязать сокет: ' . socket_strerror(socket_last_error()));
        }

        return $socket;
    }

    private function deleteSocketFileIfExists(): void
    {
        if (file_exists($this->configurator->getParam('server_socket_address'))) {
            unlink($this->configurator->getParam('server_socket_address'));
        }
    }

    private function destructSocket(): void
    {
        socket_close($this->socket);
        $this->deleteSocketFileIfExists();
    }

    public function __destruct()
    {
        $this->destructSocket();
    }
}

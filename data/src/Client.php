<?php

declare(strict_types=1);

namespace Apeskovatzkov\Hw5;

use Apeskovatzkov\Hw5\Application\Configurator;
use Apeskovatzkov\Hw5\Contracts\RunnableInterface;
use Exception;
use Socket;

class Client implements RunnableInterface
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
        while (true) {
            echo 'Введите сообщение: ';
            $message = fgets(STDIN);

            socket_sendto($this->socket, $message, strlen($message), 0, $this->configurator->getParam('server_socket_address'));

            $buffer = '';
            socket_recv($this->socket, $buffer, 1024, 0);
            echo 'Ответ от сервера: ' . '"' . trim($buffer) . '"' . PHP_EOL;
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
        if (!socket_bind($socket, $this->configurator->getParam('client_socket_address'))) {
            throw new Exception('Не удалось привязать сокет: ' . socket_strerror(socket_last_error()));
        }

        return $socket;
    }

    private function deleteSocketFileIfExists(): void
    {
        if (file_exists($this->configurator->getParam('client_socket_address'))) {
            unlink($this->configurator->getParam('client_socket_address'));
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

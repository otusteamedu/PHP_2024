<?php

declare(strict_types=1);

namespace GoroshnikovP\Hw6\SocketManager;

use GoroshnikovP\Hw6\Exceptions\RuntimeException;
use Socket;

class ServerSocketManager extends SocketManager
{
    /**
    * @var Socket Главный сокет. В рамках него создаются сокеты, для нового подключенного клиента.
     * Для нового клиента используется сокет из родительского класса.
     */
    private Socket $mainServerSocket;

    /**
     * @throws RuntimeException
     */
    public function socketInit(): void
    {
        $socket = socket_create(AF_UNIX, SOCK_SEQPACKET, 0);
        if (!($socket instanceof Socket)) {
            throw new RuntimeException('не удалось создать сокет');
        }
        $this->mainServerSocket = $socket;
        unset($socket);
        if (file_exists($this->socketFile)) {
            unlink($this->socketFile);
        }
        if (!socket_bind($this->mainServerSocket, $this->socketFile)) {
            throw new RuntimeException("Не удалось привязать сокет к файлу {$this->socketFile}. " .
                socket_strerror(socket_last_error($this->mainServerSocket)));
        }

        if (!socket_listen($this->mainServerSocket, 1)) {
            throw new RuntimeException("Не удалось сокет {$this->socketFile} перевести в режим прослушивания. " .
                socket_strerror(socket_last_error($this->mainServerSocket)));
        }
    }


    /**
     * @throws RuntimeException
     * Пояснение, почему метод ни чего не возвращает. В рамках однопоточного приложения, следующий клиент не
     * подключится, пока не завершится прежний клиент. Сокет для работы с текущим клиентом, находится в этом классе.
     */
    public function awaitClient(): void
    {
        if (!($connectedSocket = socket_accept($this->mainServerSocket))) {
            throw new RuntimeException("Ошибка socket_accept. " .
                socket_strerror(socket_last_error($this->mainServerSocket)));
        }

        $this->workingSocket = $connectedSocket;
    }
}

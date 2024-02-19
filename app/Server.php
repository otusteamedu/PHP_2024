<?php
declare(strict_types=1);

namespace Hukimato\SocketChat;

use Exception;

class Server extends SocketClient
{
    /**
     * @throws Exception
     */
    public function run(): void
    {
        $socketName = parent::getSocketNameFromServerName($this->name);

        if (file_exists($socketName)) {
            unlink($socketName);
        }

        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if (!$socket) {
            throw new Exception("Не удалось создать сокет");
        }

        if (!socket_bind($socket, $socketName)) {
            throw new Exception("Не удалось забиндить сокет");
        }

        if (!socket_listen($socket)) {
            throw new Exception("Не удалось подключиться к сокету");
        }

        while (true) {
            $connection = socket_accept($socket);
            if (!$connection) {
                throw new Exception("Не удалось получить данные из сокета");
            }

            $data = socket_read($connection, 1024);
            echo $data . PHP_EOL;

            socket_write($connection, "confirmed");

            socket_close($connection);
        }
    }
}
<?php

namespace Hukimato\SocketChat;

use Exception;

class Client extends SocketClient
{
    /**
     * @throws Exception
     */
    public function run()
    {
        $serverName = readline('Enter server name: ');

        $socketName = parent::getSocketNameFromServerName($serverName);

        while (true) {
            $message = readline('Enter message: ');

            $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
            if (!$socket) {
                throw new Exception("Не удалось создать сокет");
            }

            $connect = socket_connect($socket, $socketName);
            if (!$connect) {
                throw new Exception("Не удалось подключиться к сокету");
            }

            socket_write($socket, "{$this->name}: $message");

            $confirmation = socket_read($socket, 1024);
            if (!$confirmation) {
                throw new Exception("Подтверждения не получено");
            }
        }
    }
}
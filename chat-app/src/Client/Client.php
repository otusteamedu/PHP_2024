<?php

namespace Sfadeev\ChatApp\Client;

class Client
{
    public function send($msg)
    {
        if (($sock = socket_create(AF_UNIX, SOCK_DGRAM, 0)) === false) {
            echo "Не удалось выполнить socket_create(): причина: " . socket_strerror(socket_last_error()) . "\n";
        }

        $file = './src/var/my.sock';

        if (socket_sendto($sock, $msg, strlen($msg), 0, $file) === false) {
            echo "Не удалось выполнить socket_sendto(): причина: " . socket_strerror(socket_last_error($sock)) . "\n";
        }

        socket_close($sock);
    }
}

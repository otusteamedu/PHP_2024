<?php

namespace Sfadeev\ChatApp\Server;

class Server
{
    public function listen()
    {
        if (($sock = socket_create(AF_UNIX, SOCK_DGRAM, 0)) === false) {
            echo "Не удалось выполнить socket_create(): причина: " . socket_strerror(socket_last_error()) . "\n";
        }

        if (socket_bind($sock, './src/var/my.sock') === false) {
            echo "Не удалось выполнить socket_bind(): причина: " . socket_strerror(socket_last_error($sock)) . "\n";
        }

        $file = '';
        while (true) {
            if (socket_recvfrom($sock, $buf, 64, 0, $file) === false) {
                echo "Не удалось выполнить socket_listen(): причина: " . socket_strerror(socket_last_error($sock)) . "\n";
                break;
            }

            echo "$buf\n";
        }

        socket_close($sock);
    }
}

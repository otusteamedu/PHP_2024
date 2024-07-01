<?php

namespace script\class;

class Client
{
    public static function startClient(): void
    {
        if (!extension_loaded('sockets')) {
            die('The sockets extension is not loaded.');
        }
        $socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
        if (!$socket) {
            die('Unable to create AF_UNIX socket');
        }
        if (!socket_set_nonblock($socket)) {
            die('Unable to set nonblocking mode for socket');
        }
        $server_side_sock = dirname(__FILE__) . "/server.sock";
        echo "Enter message:\t";
        $message = stream_get_line(STDIN, 1024, PHP_EOL);
        socket_sendto($socket, $message, strlen($message), 0, $server_side_sock);
        socket_close($socket);
    }
}

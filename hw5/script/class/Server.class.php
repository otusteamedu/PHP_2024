<?php

namespace HW5;

class Server
{
    public static function startServer()
    {
        $socketObject = new Socket();
        $socket = $socketObject->getSocket();
        while (true) {
            if (!socket_set_block($socket)) {
                die('Unable to set blocking mode for socket');
            }
            $buf = '';
            $from = '';
            $bytes_received = socket_recvfrom($socket, $buf, 65536, 0, $from);
            if ($bytes_received == -1) {
                die('An error occurred while receiving from the socket');
            }
            echo $buf;
        }
    }
}

<?php

namespace HW5;

class Client
{
    public static function startClient(): void
    {
        $socketObject = new Socket();
        $socket = $socketObject->getSocket();
        while (true) {
            echo "Enter message:\t";
            $message = stream_get_line(STDIN, 1024, PHP_EOL);
            socket_sendto($socket, $message, strlen($message), 0, SOCKET_PATH);
        }
    }
}

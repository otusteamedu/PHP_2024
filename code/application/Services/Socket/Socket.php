<?php
declare(strict_types=1);

namespace App\Services\Socket;

final class Socket
{
    # Вынести в config.ini
    const SOCKET_PATH = '/tmp/phpsocket/socket.sock';

    private function create() {

        if (file_exists(self::SOCKET_PATH)) unlink(self::SOCKET_PATH);

        try {
            $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        } catch (\Exception $e) {
            echo $e->getMessage()."\n socket_create(): " . socket_strerror(socket_last_error());
            return false;
        }

        try {
            socket_bind($socket,self::SOCKET_PATH);
        } catch (\Exception $e) {
            echo $e->getMessage()."\n socket_bind(): " . socket_strerror(socket_last_error());
            return false;
        }
        return $socket;
    }


}
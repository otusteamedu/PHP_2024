<?php

declare(strict_types=1);

namespace Igorkachko\OtusSocketApp\Controllers;

class ServerController
{
    public function __invoke(string $socketPath): void
    {
        if(file_exists($socketPath)) {
            unlink($socketPath);
        }

        $sock = socket_create(AF_UNIX, SOCK_STREAM, 0);
        socket_bind($sock, $socketPath);
        socket_listen($sock,1);
        $clnt_sock = socket_accept($sock);

        do {
            $msg = socket_read($clnt_sock, 1024);
            fwrite(STDOUT, "Клиент: " . $msg . " \r\n\r\n") ;

            $answer = "Получено байт: " . strlen($msg);
            socket_write($clnt_sock, $answer, strlen($answer));

            if($msg == "Пока!")
                break;
        } while(true);

        socket_close($clnt_sock);
        socket_close($sock);

        unlink($socketPath);
    }

}
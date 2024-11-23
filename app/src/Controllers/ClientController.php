<?php

declare(strict_types=1);

namespace Igorkachko\OtusSocketApp\Controllers;

class ClientController
{
    public function __invoke(string $socketPath): void {
        $clnt_sock = socket_create(AF_UNIX, SOCK_STREAM, 0);
        socket_connect($clnt_sock, $socketPath);

        do {
            $msg = trim(fgets(STDIN));
            if(empty($msg)) {
                fwrite(STDOUT, "Пустое сообщение не отправляем! \r\n\r\n");
                continue;
            }

            socket_write($clnt_sock, $msg, strlen($msg));
            $answer = socket_read($clnt_sock, 1024);
            fwrite(STDOUT, "Сервер: " . $answer . " \r\n\r\n") ;

            if($msg == "Пока!")
                break;
        } while (true);

        socket_close($clnt_sock);
    }
}
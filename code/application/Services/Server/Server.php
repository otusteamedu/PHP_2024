<?php


namespace App\Services\Server;


use App\Services\Socket\Socket;

final class Server
{
    const SOCKET_PATH = '/tmp/phpsocket/socket.sock';

//    public function __construct()
//    {
//        $this->listen();
//    }

    private function create(): bool|\Socket
    {
        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if ($socket === false) {
            echo "Не удалось выполнить socket_create(), причина: " . socket_strerror(socket_last_error()).PHP_EOL;
            return false;
        } else echo "Сокет создан.".PHP_EOL;
        return $socket;
    }

    private function bind(): bool|\Socket
    {
        if (file_exists(self::SOCKET_PATH)) unlink(self::SOCKET_PATH);
        $socket = $this->create();
        socket_bind($socket,self::SOCKET_PATH);
        return $socket;
    }

    private function listen(): bool|\Socket
    {
        $socket = $this->bind();
        if (socket_listen($socket) === false) echo "Не удалось выполнить socket_listen(), причина: " . socket_strerror(socket_last_error($socket)) . PHP_EOL;
        ;
        return $socket;
    }

    private function accept(\Socket $socket) {
        $accept = socket_accept($socket);
        if ($accept === false) {
            echo "Не удалось выполнить socket_accept(), причина: " . socket_strerror(socket_last_error($socket)).PHP_EOL;
            return false;
        }
        return $accept;
    }

    private function write(\Socket $socket,$msg): bool
    {
//        if ($msg != trim($msg)) {
//            echo "Message validate error.".PHP_EOL;
//            return false;
//        }
        try {
            socket_write($socket, $msg, strlen($msg));
        } catch (\Exception $exception) {
            echo $exception.PHP_EOL;
            return false;
        }
        return true;
    }

    private function read(\Socket $socket,$bite = 2048) {
        $socket_read = socket_read($socket,$bite);
        if ($socket_read === false) {
            echo "Не удалось выполнить socket_read(), причина: " .
                socket_strerror(socket_last_error($socket)).PHP_EOL;
            return false;
        }
        return is_string($socket_read)? $socket_read : "Сообщения нет!";
    }

    public function run() {

        $sock = $this->listen();

        do {
            if (($msgsock = $this->accept($sock)) === false) {
                break;
            }
            /* Отправляем инструкции. */
            $msg = "\nДобро пожаловать на тестовый сервер PHP. \n" .
                "Чтобы отключиться, наберите 'выход'. Чтобы выключить сервер, наберите 'выключение'.\n";

            $this->write($msgsock,$msg);
            //socket_write($msgsock, $msg, strlen($msg));

            while (true) {
                if (false === ($buf = $this->read($msgsock))) {
                    break 2;
                }

                if (!$buf = trim($buf)) {
                    continue;
                }

                if ($buf == 'exit') {
                    echo "Socket connection closed.";
                    break;
                }

                $talkback = "PHP: Вы сказали '$buf'.\n";
                $this->write($msgsock,$talkback);
                echo "$buf\n";
            }
            socket_close($msgsock);
        } while (true);

        socket_close($sock);
    }



//unlink($path);

}
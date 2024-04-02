<?php
declare(strict_types=1);

namespace App\Services\Server;

use App\Services\Socket\Socket;

class Server extends Socket
{

    public function run() {
        $socket = $this->prepareServer();
        $exit = ($this->socketConst)['MSG_EXIT'];
        do {
            if (($acceptedConnection = $this->accept($socket)) === false) {
                break;
            }

            $msg = "Добро пожаловать на тестовый сервер PHP. ".PHP_EOL.
                "Чтобы отключиться, наберите '".$exit."'.".PHP_EOL;

            $this->write($acceptedConnection,$msg);

            while (true) {
                if (false === ($readMsg = $this->read($acceptedConnection))) {
                    break 2;
                }

                if (!$readMsg = trim($readMsg)) {
                    continue;
                }

                if ($readMsg == $exit) {
                    echo "Соединение закрыто.".PHP_EOL;
                    break;
                }

                $talkback = "PHP: Вы сказали '$readMsg'.".PHP_EOL;
                $this->write($acceptedConnection,$talkback);
                echo "$readMsg".PHP_EOL;
            }
            socket_close($acceptedConnection);
        } while (true);

        socket_close($socket);
    }

}
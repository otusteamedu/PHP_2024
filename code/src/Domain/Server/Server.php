<?php
declare(strict_types=1);

namespace App\Domain\Server;


use App\Domain\TransportInterface\TransportInterface;

class Server
{

    public function run(TransportInterface $transport) {
        $transport->prepareServer();
        $exit = $transport->getExitKey();
        do {
            if (($acceptedConnection = $transport->accept()) === false) {
                break;
            }

            $msg = "Добро пожаловать на тестовый сервер PHP. ".PHP_EOL.
                "Чтобы отключиться, наберите '".$exit."'.".PHP_EOL;

            $transport->write($msg);

            while (true) {
                if (false === ($readMsg = $transport->read())) {
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
                $transport->write($talkback);
                echo "$readMsg".PHP_EOL;
            }
            $transport->close();
        } while (true);

        $transport->close();
    }

}
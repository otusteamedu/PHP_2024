<?php

declare(strict_types=1);

namespace Rrazanov\Hw5;

use Exception;

class Client
{
    private Socket $socket;

    public function __construct()
    {
        $this->socket = new Socket();
    }

    /**
     * @throws Exception
     */
    public function startClient()
    {
        $this->socket->connectSocket();
        do {
            $clientText = readline('Отправить сообщение: ');
            if (strlen($clientText) == 0) {
                echo 'PHP: Пустое сообщение не отправлено' . "\n";
                continue;
            }
            $this->socket->sendMessage($clientText);

            $bytes_received = $this->socket->readSocket();
            if ($bytes_received) {
                echo $bytes_received . "\n";
            } else {
                echo 'Сервер отлючён';
            }
        } while (true);
    }
}

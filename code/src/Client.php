<?php

declare(strict_types=1);

namespace TimurShakirov\SocketChat;

use Exception;

class Client
{
    public $client;

    public function __construct($host, $port, $length)
    {
        $this->client = new UnixSocket($host, $port, $length);
    }

    public function app()
    {
        $this->client->socketConnect();
            while (true) {
                echo 'Введите сообщение. Для выхода нажмите CTRL + C (Windows, Linux) или CMD + C (Mac)' . PHP_EOL;
                $msg = fgets(STDIN);
                if (!$this->client->sendMessage($msg)) {
                    echo 'Не удалось отправить сообщение. Сеанс завершен' . PHP_EOL;
                    break;
                }
            }
            $this->client->closeSession();
    }
}

<?php

declare(strict_types=1);

namespace TimurShakirov\SocketChat;

use Exception;

class Client
{
    public $client;

    public function __construct($file, $length)
    {
        $this->client = new UnixSocket($file, $length);
    }

    public function app()
    {
        $this->client->socketConnect();
        while (true) {
            foreach ($this->getMsg() as $msg) {
                if (!$this->client->sendMessage($msg)) {
                    echo 'Не удалось отправить сообщение. Сеанс завершен' . PHP_EOL;
                    $this->client->closeSession();
                    return;
                }
            }
        }
    }

    private function getMsg() 
    {
        echo 'Введите сообщение. Для выхода нажмите CTRL + C (Windows, Linux) или CMD + C (Mac)' . PHP_EOL;
        $msg = fgets(STDIN);
        yield $msg;
    }
}

<?php

declare(strict_types=1);

namespace Chat\client;

use Chat\socket\UnixSocket as Socket;

class Client
{
    public $client;

    public function __construct($host, $port, $maxlen)
    {
        $this->client = new Socket($host, $port, $maxlen);
    }

    public function app()
    {
        $this->client->socketConnect();
        while (true) {
            $msg = readline("Введите сообщение: ") . "\n";
            $this->client->sendMessage($msg);
            if (strpos($msg, "STOP") === true) {
                break;
            };
        };
        $this->client->closeSession();
    }
}

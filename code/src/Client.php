<?php

declare(strict_types=1);

namespace PavelMiasnov\PhpSocketChat;

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
            echo 'Input message' . PHP_EOL;

            $msg = fgets(STDIN);
            $this->client->sendMessage($msg);
            if (trim($msg) === 'exit') {
                echo "Сеанс завершен \n";
                break;
            }
        }
        $this->client->closeSession();
    }
}
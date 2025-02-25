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

    public function app(callable $inputProvider = null): void
    {
        $this->client->socketConnect();
        $inputProvider = $inputProvider ?? function () {
            return fgets(STDIN);
        };
        while (true) {
            echo 'Input message' . PHP_EOL;
            $msg = $inputProvider();
            $this->client->sendMessage($msg);
            if (trim($msg) === 'exit') {
                echo "Сеанс завершен \n";
                break;
            }
        }
        $this->client->closeSession();
    }
}

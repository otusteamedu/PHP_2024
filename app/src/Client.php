<?php

declare(strict_types=1);

namespace Lrazumov\Hw5;

class Client
{
    private Config $config;
    private Socket $socket;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function run()
    {
        echo 'Client started' . PHP_EOL;
        $this->socket = new Socket($this->config);
        $this->socket->create();
        $this->socket->create();
        $this->socket->connect();
        do {
            $server_message = $this->socket->readMessage();
            echo sprintf("MESSAGE '%s' from server \n", $server_message);
            $client_message = readline("Write your message \n");
            $this->socket->sendMessage($client_message);
            break;
        } while (true);
        $this->socket->close();
        echo 'Client stopped' . PHP_EOL;
    }
}

<?php

use Sfadeev\ChatApp\Server\Server;
use Sfadeev\ChatApp\Client\Client;

require dirname(__DIR__).'/vendor/autoload.php';

switch ($argv[1]) {
    case 'start-server':
        startServer();
        break;
    case 'start-client':
        startClient();
}

function startServer()
{
    $server = new Server();
    $server->listen();
}

function startClient()
{
    $stdin = fopen("php://stdin", "r");
    while(true) {
        print("---\n");
        print("Введите сообщение. (Пустая строка для выхода)\n");
        $data = trim(fgets($stdin));
        if ("" === $data) {
            break;
        }
        $client = new Client();
        $client->send($data);
        echo("Сообщение отправлено\n");
    }
    fclose($stdin);
}

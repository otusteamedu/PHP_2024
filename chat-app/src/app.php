<?php

use Sfadeev\ChatApp\Client\Client;
use Sfadeev\ChatApp\Server\Server;
use Sfadeev\ChatApp\Socket\UnixSocket;

require dirname(__DIR__) . '/vendor/autoload.php';

const SERVER_LISTEN_SOCKET_PATH = __DIR__ . '/var/server_listen.sock';
const SCLIENT_LISTEN_SOCKET_PATH = __DIR__ . '/var/client_listen.sock';

$serverListenSock = new UnixSocket(SERVER_LISTEN_SOCKET_PATH);
$clientListenSock = new UnixSocket(SCLIENT_LISTEN_SOCKET_PATH);

$input = fopen("php://stdin", "r");
$output = fopen("php://stdout", "w");

switch ($argv[1]) {
    case 'start-server':
        (new Server($serverListenSock, $clientListenSock, $output))->listen();
        break;
    case 'start-client':
        if (!file_exists(SERVER_LISTEN_SOCKET_PATH)) {
            throw new RuntimeException(sprintf("Socket %s doesn't exist. Probable reason - the server is not running.", SERVER_LISTEN_SOCKET_PATH));
        }

        (new Client($serverListenSock, $clientListenSock, $input, $output))->startMessaging();
        break;
}

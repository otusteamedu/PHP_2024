<?php
// server.php

require 'vendor/autoload.php';

use App\ChatServer;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new ChatServer()
        )
    ),
    38081,
    '0.0.0.0'
);

echo "WebSocket server is running on ws://0.0.0.0:38081\n";
$server->run();
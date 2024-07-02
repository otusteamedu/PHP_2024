<?php

namespace HW5;

class App
{
    public function run()
    {
        $params = $_SERVER['argv'];
        match ($params[1]) {
            'start-server' => Server::startServer(),
            'start-client' => Client::startClient()
        };
    }
}

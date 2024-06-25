<?php

namespace Evgenyart\UnixSocketChat;

use Exception;

class App
{
    private $socketPath;

    public function __construct()
    {
        $this->socketPath = Config::load();
    }

    public function run()
    {
        $args = $_SERVER['argv'];
        $ExceptionError = "Необходимо ввести параметр `start-server` либо `start-client`";

        if (!isset($args[1])) {
            throw new Exception($ExceptionError);
        } else {
            switch ($args[1]) {
                case 'start-server':
                    $server = new Server($this->socketPath);
                    $server->start();
                    break;
                case 'start-client':
                    $client = new Client($this->socketPath);
                    $client->start();
                    break;
                default:
                    throw new Exception($ExceptionError);
                    break;
            }
        }
    }
}

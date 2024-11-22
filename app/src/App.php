<?php

namespace Evgenyart\UnixSocketChat;

use Evgenyart\UnixSocketChat\Exceptions\AppException;

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

        if (!isset($args[1])) {
            throw new AppException("Не введен параметр запуска (ожидается `start-server` либо `start-client`)");
        }

        switch ($args[1]) {
            case 'start-server':
                $this->startServer();
                echo "Server is running";
                break;
            case 'start-client':
                $this->startClient();
                echo "Client is running";
                break;
            default:
                throw new AppException("Неизвестный параметр. Ожидается `start-server` либо `start-client`");
                break;
        }
    }

    public function startServer()
    {
        $server = new Server($this->socketPath);
        $server->start();
    }

    public function startClient()
    {
        $client = new Client($this->socketPath);
        $client->start();
    }

    public function getSocketPath()
    {
        return $this->socketPath;
    }
}

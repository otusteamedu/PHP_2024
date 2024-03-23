<?php

declare(strict_types=1);

namespace Main;

use Dotenv\Dotenv;

class App
{
    private static $instance;

    private $logger;

    protected function __construct()
    {
    }

    protected function __clone()
    {
    }


    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize singleton");
    }


    public static function getInstance(): self
    {
        if (empty(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }


    public function run($argv): \Generator
    {
        if (empty($argv[1])) {
            throw new \Exception('Не передано действие');
        }

        if ($argv[1] == 'server') {
            return $this->runServer();
        } elseif ($argv[1] == 'client') {
            return $this->runClient();
        } else {
            throw new \Exception('Передано не существующие действие');
        }
    }


    public function runClient()
    {
        $socketClient = new SocketClient();
        foreach ($socketClient->runClientListener() as $message) {
            yield $message;
        }
        $socketClient->closeSocket();
    }


    public function runServer(): \Generator
    {
        $socketServer = new SocketServer();

        foreach ($socketServer->runListener() as $message){
            yield $message;
        }

        $socketServer->closeSocket();
    }








}

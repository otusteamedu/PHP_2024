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
        $logger = new ConsoleLog();
        $this->setLogger($logger);
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


    public function run($argv): void
    {
        if (empty($argv[1])) {
            throw new \Exception('Не передано действие');
        }

        if ($argv[1] == 'server') {
            $this->runServer();
        } elseif ($argv[1] == 'client') {
            $this->runClient();
        } else {
            throw new \Exception('Передано не существующие действие');
        }
    }


    public function runClient(): void
    {
        $socketClient = new SocketClient();
        $socketClient->runClientListener();
        $socketClient->closeSocket();
    }


    public function runServer(): void
    {
        $socketServer = new SocketServer();
        $socketServer->runListener();
        $socketServer->closeSocket();
    }


    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }



}

<?php

declare(strict_types=1);

namespace Main;

use Dotenv\Dotenv;

class App
{
    private static $instance;

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


    public function run($argv): void
    {
        if (empty($argv[1])) {
            throw new \Exception('Не передано действие');
        }

        if ($argv[1] == 'server') {
            $this->runServer();
        } elseif ($argv[1] == 'client') {
            $this->runClient();
        }

        throw new \Exception('Передано не существующие действие');
    }


    public function runClient(): void
    {
        $socketClient = new SocketClient();
        while (true) {

            echo PHP_EOL . "Введите что-нибудь (для выхода введите 'exit'): ";

            $input = fgets(STDIN);

            $input = trim($input);

            if ($input === 'exit') {
                echo "До свидания!\n";
                break;
            }
            $socketClient->sendMessage($input);
        }

        $socketClient->closeSocket();
    }


    public function runServer(): void
    {
        $socketServer = new SocketServer();
        $socketServer->runListner();
        $socketServer->closeSocket();
    }

}

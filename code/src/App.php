<?php

declare(strict_types=1);

namespace TimurShakirov\SocketChat;

use Exception;
use TimurShakirov\SocketChat\Server;
use TimurShakirov\SocketChat\Client;

class App
{
    public $config;
    public $host;
    public $port;
    public $length;

    public function __construct()
    {
        $this->host = "0.0.0.0";
        $this->port = 4444;
        $this->length = 2048;
    }

    /**
     * @throws Exception
     */
    public function run(): void
    {
        $args = $_SERVER['argv'][1] ?? null;
        switch ($args) {
            case 'server':
                $server = new Server($this->host, $this->port, $this->length);
                $server->app();
                break;
            case 'client':
                $client = new Client($this->host, $this->port, $this->length);
                $client->app();
                break;
            default:
                throw new Exception("Неверный аргумент: `server` для старта сервера или `client` для старта клиента" . PHP_EOL);
        }
    }
}

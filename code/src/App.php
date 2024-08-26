<?php

declare(strict_types=1);

namespace PavelMiasnov\PhpSocketChat;

use Exception;

class App
{
    public $config;
    public $host;
    public $port;
    public $length;

    public function __construct()
    {
        $this->config = parse_ini_file(__DIR__ . "/config.ini");
        $this->host = $this->config["host"];
        $this->port = intval($this->config["port"]);
        $this->length = intval($this->config["length"]);
    }

    /**
     * @throws Exception
     */
    public function run(): void
    {
        $mode = $_SERVER['argv'][1] ?? null;
        switch ($mode) {
            case 'server':
                $server = new Server($this->host, $this->port, $this->length);
                $server->app();
                break;
            case 'client':
                $client = new Client($this->host, $this->port, $this->length);
                $client->app();
                break;
            default:
                throw new Exception("Неверный аргумент. Доступны только `server` или `client`");
        }
    }
}
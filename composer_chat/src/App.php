<?php

namespace Chat\app;

use Chat\server\Server;
use Chat\client\Client;
use Exception;

class App
{
    public $config;
    public $host;
    public $port;
    public $maxlen;

    public function __construct()
    {
        $this->config = parse_ini_file(__DIR__ . "/conf.ini");
        $this->host = $this->config["host"];
        $this->port = intval($this->config["port"]);
        $this->maxlen = intval($this->config["len"]);
    }

    public function run($mode)
    {
        switch ($mode) {
            case 'server':
                $server = new Server($this->host, $this->port, $this->maxlen);
                $server->app();
                break;
            case 'client':
                $client = new Client($this->host, $this->port, $this->maxlen);
                $client->app();
                break;
            default:
                throw new Exception("Неверный аргумент. Доступны `server` или `client`");
        }
    }
}

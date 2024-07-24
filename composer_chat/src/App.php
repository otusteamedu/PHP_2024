<?php

namespace Chat\app;
use Chat\server\Server;
use Chat\client\Client;
use Exception;

class App
{
    public $host;
    public $port;
    public $maxlen;

    function __construct()
    {
        $config = parse_ini_file(__DIR__ . "/conf.ini");
        $this->host = $config["host"];
        $this->port = intval($config["port"]);
        $this->maxlen = intval($config["len"]);
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
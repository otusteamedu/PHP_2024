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

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $configFile = __DIR__ . "/config.ini";
        if (!file_exists($configFile)) {
            throw new Exception("Configuration file '$configFile' not found");
        }
        $this->config = parse_ini_file($configFile);
        $this->host = $this->config["host"];
        $this->port = intval($this->config["port"]);
        $this->length = intval($this->config["length"]);
    }

    /**
     * @throws Exception
     */
    public function run(?Server $server = null, ?Client $client = null): void
    {
        $mode = $_SERVER['argv'][1] ?? null;
        switch ($mode) {
            case 'server':
                $server = $server ?? new Server($this->host, $this->port, $this->length);
                $server->app();
                break;
            case 'client':
                $client = $client ?? new Client($this->host, $this->port, $this->length);
                $client->app();
                break;
            default:
                throw new Exception("Неверный аргумент. Доступны только `server` или `client`");
        }
    }
}

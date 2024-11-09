<?php
namespace AlexAgapitov\OtusComposerProject;

use Exception;

class App
{
    public $config;
    public $file;
    public $length;

    public function __construct()
    {
        $this->config = parse_ini_file(__DIR__ . "/config.ini");
        $this->file = $this->config["file"];
        $this->length = intval($this->config["length"]);
    }

    /**
     * @throws Exception
     */
    public function run()
    {
        if (!isset($_SERVER['argv'][1])) {
            throw new Exception("Не введен параметр запуска");
        }
        $args = $_SERVER['argv'][1];
        switch ($args) {
            case 'server':
                $this->startServer();
                echo "Server start";
                break;
            case 'client':
                $this->startClient();
                echo "Client start";
                break;
            default:
                throw new Exception("Неверный аргумент: `server` для старта сервера или `client` для старта клиента");
        }
    }

    public function startServer()
    {
        $server = new Server($this->file, $this->length);
        $server->app();
    }

    public function startClient()
    {
        $client = new Client($this->file, $this->length);
        $client->app();
    }


}
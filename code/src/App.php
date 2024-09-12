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
    public function run(): void
    {
        $args = $_SERVER['argv'][1] ?? null;
        switch ($args) {
            case 'server':
                $server = new Server($this->file, $this->length);
                $server->app();
                break;
            case 'client':
                $client = new Client($this->file, $this->length);
                $client->app();
                break;
            default:
                throw new Exception("Неверный аргумент: `server` для старта сервера или `client` для старта клиента" . PHP_EOL);
        }
    }
}
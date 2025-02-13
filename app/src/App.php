<?php

namespace SlavaMakhov\OtusTestApp;

use Exception;

class App
{
    /** @var string */
    public string $file;

    /** @var int */
    public int $length;

    public function __construct()
    {
        $getConfig = parse_ini_file(__DIR__ . "/config.ini");
        $this->file = $getConfig["socket_path"];
        $this->length = (int)$getConfig["socket_length"];
    }

    /**
     * Старт приложения
     *
     * @throws Exception
     */
    public function run(): void
    {
        if (!isset($_SERVER['argv'][1])) {
            throw new Exception("Launch start not transmitted!");
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
                throw new Exception("Enter one of the options: server or client" . PHP_EOL);
        }
    }

    /**
     * Старт Сервера
     *
     * @throws Exception
     */
    public function startServer()
    {
        $server = new Server($this->file, $this->length);
        $server->run();
    }

    /**
     * Старт Клиента
     *
     * @throws Exception
     */
    public function startClient()
    {
        $client = new Client($this->file, $this->length);
        $client->run();
    }
}

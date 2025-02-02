<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusChatSocketsApp;

use Exception;

class App
{
    public string $file;
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
        $args = $_SERVER['argv'][1] ?? null;

        switch ($args) {
            case 'server':
                (new Server($this->file, $this->length))->run();
                break;
            case 'client':
                (new Client($this->file, $this->length))->run();
                break;
            default:
                throw new Exception("Введите один из вариантов: server или client" . PHP_EOL);
        }
    }
}

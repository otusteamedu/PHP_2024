<?php

declare(strict_types=1);

namespace Igorkachko\OtusSocketApp;

use Igorkachko\OtusSocketApp\Controllers\ClientController;
use Igorkachko\OtusSocketApp\Controllers\ServerController;
use Symfony\Component\Dotenv\Dotenv;

class App
{

    public function __construct()
    {
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__.'/../../.env');
    }

    public function run(): void {
        global $argv;
        global $argc;

        if($argc !== 2) {
            throw new \Exception("Нужно обязательно указать один контроллер [server|client]");
        }


        if(empty($_ENV["SOCKET_PATH"]) || empty($_ENV["SOCKET_NAME"])) {
            throw new \Exception("Не указан файл сокета в настройках окружения.");
        }

        $socketPath = $_ENV["SOCKET_PATH"] . $_ENV["SOCKET_NAME"];

        $controller = match ($argv[1]) {
            "client" => new ClientController(),
            "server" => new ServerController(),
            default => null,
        };

        if(!empty($controller) && is_callable($controller)) {
            $controller($socketPath);
        } else {
            throw new \Exception("Не найден подходящий контроллер");
        }
    }
}
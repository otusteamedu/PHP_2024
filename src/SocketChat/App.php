<?php

//шпора https://github.com/otusteamedu/PHP_2024/blob/DSergei/hw5/app/src/AbstractSocket.php

namespace SocketChat;

class App
{
    public function run(): void
    {
        $mode = isset($_SERVER['argv'][1]) ? $_SERVER['argv'][1] : '';
        switch ($mode) {
            case 'server':
                $server = new Server();
                $server->run();
                break;
            case 'client':
                $client = new Client();
                $client->run();
                break;
            default:
                throw new \Exception('Не найден режим "' . $mode . '"' . PHP_EOL);
                break;
        }
    }
}

<?php

declare(strict_types=1);

namespace ABuynovskiy\Hw5;

class App
{
    /**
     * @param string[] $argv
     * @throws Exception
     */
    public function run(int $argc, array $argv): void
    {
        if ($argc <= 1) {
            throw new Exception('Не передан аргумент.');
        }

        $command = $argv[1];
        switch ($command) {
            case 'server':
                $this->handleServer();
                break;
            case 'client':
                $this->handleClient();
                break;
            default:
                throw new Exception("Неизвестная команда: $command");
        }
    }

    /**
     * вызывает методы сервера
     */
    private function handleServer(): void
    {
        $server = new Server();
        foreach ($server->run() as $message) {
            echo $message;
        }
    }

    /**
     * вызывает методы клиента
     */
    private function handleClient(): void
    {
        $client = new Client();
        foreach ($client->run() as $message) {
            echo $message;
        }
    }
}

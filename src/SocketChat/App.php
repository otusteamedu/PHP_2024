<?php

namespace SocketChat;

class App
{
    public function run()
    {
        $mode = isset($_SERVER['argv'][1]) ? $_SERVER['argv'][1] : '';

        match ($mode) {
            'server' => $this->runServer(),
            'client' => $this->runClient(),
            default => throw new \Exception('Не найден режим "' . $mode . '"' . PHP_EOL)
        };
    }

    protected function runServer()
    {
        $server = new Server();
        $server->run();
    }

    protected function runClient()
    {
        $client = new Client();
        $client->run();
    }
}

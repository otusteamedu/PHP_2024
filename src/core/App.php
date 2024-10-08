<?php

namespace Ali\Socket;

class App
{
    public Config $config;
    public mixed $file;
    public int $length;

    public function __construct()
    {
        $this->config = new Config(__DIR__ . "/config.ini");
        $this->file = $this->config->get("file");
        $this->length = intval($this->config->get("length"));
    }

    public function run(): void
    {
        $args = $_SERVER['argv'][1] ?? null;

        match ($args) {
            'server' => (new Server($this->file, $this->length))->app(),
            'client' => (new Client($this->file, $this->length))->app(),
            default => "Неверный аргумент. Передайте для сервера server, для клиента client" . PHP_EOL,
        };
    }
}

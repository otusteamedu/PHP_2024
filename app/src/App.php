<?php

declare(strict_types=1);

namespace Lrazumov\Hw5;

use Exception;

class App
{
    private string $mode;
    private Config $config;

    function __construct(string $mode, Config $config) {
        if (!in_array($mode, ['server', 'client'], true)) {
            throw new Exception('Run the script in "server" or "client" mode.');
        }
        $this->mode = $mode;
        $this->config = $config;
    }

    public function run()
    {
        $chat = match ($this->mode) {
            'server' => new Server($this->config),
            'client' => new Client($this->config)
        };
        $chat->run();
    }
}

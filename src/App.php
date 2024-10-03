<?php

declare(strict_types=1);

namespace Otus\SocketChat;

use Exception;

class App
{
    private ?Config $config;
    private ?string $mode;
    private string $socketFile;

    public function __construct(?Config $config)
    {

        $this->config = $config ?? new SocketConfig();

        if ($_SERVER['argc'] !== 2) {
            throw new Exception('Неверное количество аргументов');
        }

        $this->mode = $_SERVER['argv'][1];
        $this->socketFile = $this->config->socketFile;
    }

    /**
     * @throws Exception
     */
    public function run()
    {

        $socket = new Socket($this->socketFile);

        $modeType = match ($this->mode) {
            'server' => new Server($socket),
            'client' => new Client($socket),
            default => throw new Exception('Неверный тип'),
        };
        $modeType->start();
    }
}

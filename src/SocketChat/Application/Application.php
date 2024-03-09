<?php

declare(strict_types=1);

namespace AlexanderGladkov\SocketChat\Application;

use AlexanderGladkov\SocketChat\Config\Config;
use AlexanderGladkov\SocketChat\Client\Client;
use AlexanderGladkov\SocketChat\Server\Server;
use LogicException;
use InvalidArgumentException;

class Application
{
    private ?Mode $mode;

    public function __construct(array $argv)
    {
        $modeArgument = $argv[1] ?? null;
        if (is_null($modeArgument)) {
            throw new InvalidArgumentException('Первым аргументом нужно указать режим работы приложения!');
        }

        $this->mode = Mode::tryFrom($modeArgument);
        if ($this->mode === null) {
            throw new InvalidArgumentException(
                'Возможные значения для первого аргумента: ' . implode(', ', Mode::values()) . '.'
            );
        }
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function run(): void
    {
        $config = new Config(__DIR__ . '/../../config/app.ini');
        if ($this->mode === Mode::Client) {
            (new Client($config))->run();
            return;
        }

        if ($this->mode === Mode::Server) {
            (new Server($config))->run();
            return;
        }

        throw new LogicException();
    }
}

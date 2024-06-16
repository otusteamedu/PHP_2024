<?php

declare(strict_types=1);

namespace AlexanderGladkov\SocketChat\Application;

use AlexanderGladkov\SocketChat\Config\Config;
use AlexanderGladkov\SocketChat\Client\Client;
use AlexanderGladkov\SocketChat\Server\Server;
use Generator;
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
     * @return Generator<string>
     * @throws \Exception
     */
    public function run(): Generator
    {
        $config = new Config(__DIR__ . '/../../config/app.ini');
        if ($this->mode === Mode::Client) {
            return (new Client($config))->run();
        }

        if ($this->mode === Mode::Server) {
            return (new Server($config))->run();
        }

        throw new LogicException();
    }
}

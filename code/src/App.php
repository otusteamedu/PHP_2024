<?php

declare(strict_types=1);

namespace Otus\Chat;

use Exception;

class App
{
    public $mode;
    public $socket;

    public const REQUIRED_NUMBER_OF_ARGUMENTS = 2;

    public function __construct()
    {
        if ($_SERVER['argc'] !== self::REQUIRED_NUMBER_OF_ARGUMENTS) {
            throw new Exception('invalid arguments');
        }

        $this->mode = $_SERVER['argv'][1];
        $this->socket = (new Config())->socketPath;
    }

    /**
     * @throws Exception
     */
    public function run(): void
    {
        $app = match ($this->mode) {
            'server' => new Server($this->socket),
            'client' => new Client($this->socket),
            default => throw new Exception('invalid app mode'),
        };
        $app->run();
    }
}

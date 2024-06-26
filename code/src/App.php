<?php

declare(strict_types=1);

namespace Otus\Chat;

class App
{
    public $mode;
    public $socket;

    public function __construct()
    {
        if ($_SERVER['argc'] !== 2) {
            throw new \Exception('invalid arguments');
        }

        $this->mode = $_SERVER['argv'][1];
        $this->socket = (new Config())->socketPath;
    }

    public function run()
    {
        switch ($this->mode) {
            case 'server':
                $app = new Server($this->socket);
                break;
            case 'client':
                $app = new Client($this->socket);
                break;
            default:
                throw new \Exception('invalid app mode');
        }
        $app->run();
    }
}

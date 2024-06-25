<?php

declare(strict_types=1);

namespace Otus\Chat;

class App
{
    public $mode;

    public function __construct()
    {
        if ($_SERVER['argc'] !== 2)
            new Error('invalid arguments');

        $this->mode = $_SERVER['argv'][1];
    }

    public function run()
    {
        switch ($this->mode) {
            case 'server':
                $app = new Server();
                break;
            case 'client':
                $app = new Client();
                break;
            default:
                new Error('invalid app mode');
                break;
        }
        $app->run();
    }
}

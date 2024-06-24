<?php

declare(strict_types=1);

namespace Otus\Chat;

class App
{
    public $mode;
    public $socket;

    public function __construct()
    {
        $this->mode = $_SERVER['argv'][1];
        // $this->socket = $socket;
    }

    public function run()
    {
        if ($this->mode === 'server') {
            $app = new Server();
        } else {
            $app = new Client();
        }
        $app->run();
    }
}

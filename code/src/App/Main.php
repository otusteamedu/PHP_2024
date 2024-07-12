<?php

namespace src\App;

use Exception;
use src\Socket\Settings;
use src\Socket\Main as SocketMain;

class Main
{
    /**
     * @throws Exception
     */
    public function run($arg): void
    {
        $settings = new Settings();
        $app = match ($arg) {
            'server' => new Server(new SocketMain($settings)),
            'client' => new Client(new SocketMain($settings)),
            default => throw new Exception('Wrong app type'),
        };
        $app->start();
    }
}

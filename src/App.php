<?php

declare(strict_types=1);

namespace Udavikhin\OtusHw5;

class App
{
    public function run()
    {
        $command = $_SERVER['argv'][1];

        switch ($command) {
            case 'client':
                Client::init();
                break;
            case 'server':
                Server::init();
                break;
        }
    }
}
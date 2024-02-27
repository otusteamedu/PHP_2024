<?php

declare(strict_types=1);

namespace Kagirova\Hw5;

class App
{

    public function run($args)
    {
        if (empty($args[1])) {
            throw new \Exception('Must have an argument');
        }
        switch ($args[1]) {
            case 'server':
                $client = new Server();
                $client->run();
                break;
            case 'client':
                $client = new Client();
                $client->run();
                break;
            default:
                throw new \Exception('Must have one argument: client or server');
        }
    }
}
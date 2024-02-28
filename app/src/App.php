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
        $config = Config::create();

        $chat = match ($args[1]) {
            'server' => new Server(new UnixSocket($config)),
            'client' => new Client(new UnixSocket($config)),
            default => throw new \Exception('Must have one argument: client or server')
        };
        $chat->run();
    }
}

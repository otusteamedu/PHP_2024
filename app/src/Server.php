<?php

declare(strict_types=1);

namespace Lrazumov\Hw5;

class Server
{
    private Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function run()
    {
        echo 'Server started' . PHP_EOL;
        echo 'Server stopped' . PHP_EOL;
    }
}

<?php

declare(strict_types=1);

namespace Lrazumov\Hw5;

class Client
{
    private Config $config;

    function __construct(Config $config) {
        $this->config = $config;
    }

    public function run()
    {
        echo 'Client started' . PHP_EOL;
        echo 'Client stopped' . PHP_EOL;
    }
}

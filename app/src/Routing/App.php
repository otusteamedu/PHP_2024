<?php

declare(strict_types=1);

namespace App\Routing;

class App
{
    /**
     * @return void
     * @throws \RedisException
     */
    public function run(): void
    {
        print_r((new Routing())->getRout($_SERVER['REQUEST_URI']));
    }
}

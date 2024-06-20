<?php

declare(strict_types=1);

namespace Orlov\Otus;

use Symfony\Component\Dotenv\Dotenv;

class App
{
    public function __construct()
    {
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__ . '/../.env');
    }

    public function __invoke(): void
    {
        (new Route($_SERVER['REQUEST_URI']))->run();
    }
}

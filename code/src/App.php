<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw19;

use Asyrovatkin\Hw19\Classes\Router;

class App
{
    public Router $router;

    public function __construct()
    {
        $this->router = new Router();
    }

    public function run(): void
    {
        echo $this->router->resolve();
    }
}
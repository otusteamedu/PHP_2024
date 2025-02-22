<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw11;

use Asyrovatkin\Hw11\Classes\Request;
use Asyrovatkin\Hw11\Classes\Router;

class App
{
    public Router $router;

    public function __construct()
    {
        $request = new Request();
        $this->router = new Router($request);
    }

    public function run(): void
    {
        echo $this->router->resolve();
    }
}
<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw14;

use Asyrovatkin\Hw14\Infrastructure\Api\Router;

class App
{
    private Router $router;

    public function __construct()
    {
        $this->router = new Router();
    }

    public function run()
    {
        return $this->router->resolve();
    }
}
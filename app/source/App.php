<?php

namespace Pavelsergeevich\Hw6;

use Pavelsergeevich\Hw6\Core\Router;

class App
{
    public function run(): void
    {
        $router = new Router();
        $router->run();
    }
}
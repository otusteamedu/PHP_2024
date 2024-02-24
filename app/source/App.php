<?php

namespace Pavelsergeevich\Hw6;

use Pavelsergeevich\Hw6\Core\Router;

class App
{
    public function run(): void
    {
        $this->runPreload();
        $router = new Router();
        $router->run();
    }

    private function runPreload(): void
    {
        //Вывод ошибок
        error_reporting(0);
    }
}
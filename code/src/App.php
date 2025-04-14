<?php
declare(strict_types=1);

namespace App;

use App\Infrastructure\Components\Router;

class App
{

    public function run():void
    {
        $app = new Router();
        $app->run();

    }

}
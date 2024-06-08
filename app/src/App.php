<?php

declare(strict_types=1);

namespace Kagirova\Hw21;

use Kagirova\Hw21\Application\Publisher\Publisher;
use Kagirova\Hw21\Application\Request\Request;
use Kagirova\Hw21\Application\Router;
use Kagirova\Hw21\Infrastructure\Database\PostgresStorage;

class App
{
    public function run()
    {
        $postgresStorage = new PostgresStorage();
        $postgresStorage->connect();

        $publisher = Publisher::getInstance();
        $publisher->init($postgresStorage);

        $request = Request::capture();

        $router = new Router($request, $postgresStorage);
        $useCase = $router->resolve();

        $useCase->run();
    }
}

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

        $publisher = new Publisher($postgresStorage);

        $request = Request::capture();

        $router = new Router($request, $postgresStorage, $publisher);
        $useCase = $router->resolve();

        $useCase->run();
    }
}

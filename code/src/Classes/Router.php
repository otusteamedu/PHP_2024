<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw19\Classes;

use Asyrovatkin\Hw19\Controllers\BankController;
use Asyrovatkin\Hw19\Storages\MongoDb\MongoDb;

class Router
{
    private array $routes;
    public Request $request;

    public function __construct()
    {
        $this->request = new Request();
        $this->routes = $this->getRoutes();
    }

    public function resolve()
    {
        $params = $this->request->getPath();
        $path = array_shift($params);
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;

        if ($callback === false) {
            return "404";
        }

        return call_user_func($callback, array_shift($params));
    }

    private function getRoutes(): array
    {
        return [
            'get' => [
                'main' => function() {
                    echo file_get_contents('./src/Views/main.html');
                },
            ],
            'post' => [
                'main' => function() {
                    (new BankController())->requestBalance();
                },
            ]
        ];
    }
}
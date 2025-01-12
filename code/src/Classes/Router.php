<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw11\Classes;

use Asyrovatkin\Hw11\Controllers\EventController;
use Asyrovatkin\Hw11\Storages\MongoDb\MongoDb;

class Router
{
    private array $routes;
    public Request $request;

    public function __construct()
    {
        $this->request = new Request();
        $this->routes = $this->getRoutes();
    }

    public function get($path, $callback): void
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback): void
    {
        $this->routes['post'][$path] = $callback;
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
                'clear' => function() {
                    (new EventController())->clearStorage();
                },
                'search' => function() {
                    echo file_get_contents('./src/Views/search.html');
                },
                'test' => function() {
                    new MongoDb();
                }
            ],
            'post' => [
                'main' => function() {
                    (new EventController())->putEvent();
                },
                'search' => function() {
                    (new EventController())->getEventIdsByParamsWithMaxPriority();
                }
            ]
        ];
    }
}
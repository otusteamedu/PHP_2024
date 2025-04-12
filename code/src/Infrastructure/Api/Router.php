<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw14\Infrastructure\Api;

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
            'post' => [
                'add' => function() {
                    return (new ApiController())->addNews();
                },
                'create_report' => function() {
                    return (new ApiController())->createNewsReport();
                },
            ],
            'get' => [
                'get_list' => function() {
                    return (new ApiController())->getNewsList();
                },
            ]
        ];
    }
}
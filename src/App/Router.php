<?php

namespace VSukhov\Hw11\App;

use Closure;
use VSukhov\Hw11\Exception\AppException;

class Router
{
    protected array $routes = [];

    public function addRoute(string $method, string $url, Closure $target): void
    {
        $this->routes[$method][$url] = $target;
    }

    /**
     * @throws AppException
     */
    public function matchRoute(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $url = $_SERVER['REQUEST_URI'];
        if (isset($this->routes[$method])) {
            foreach ($this->routes[$method] as $routeUrl => $target) {
                if ($routeUrl === $url) {
                    call_user_func($target);
                    exit;
                }
            }
        }

        throw new AppException('Route not found');
    }
}

<?php

declare(strict_types=1);

namespace hw14;

class Router
{
    protected $routes = []; // stores routes

    public function addRoute(string $method, string $url, \Closure $target)
    {
        $this->routes[$method][$url] = $target;
    }

    public function matchRoute()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $url = $_SERVER['REQUEST_URI'];

        $clearUrl = explode("?", $url)[0];

        if (isset($this->routes[$method])) {
            foreach ($this->routes[$method] as $routeUrl => $target) {
                // Simple string comparison to see if the route URL matches the requested URL
                if ($routeUrl === $clearUrl) {
                    return call_user_func($target);
                }
            }
        }
        throw new \Exception('Route not found');
    }
}

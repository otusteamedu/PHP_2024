<?php

namespace AnatolyShilyaev\Backend\Infrastructure\Http;

class Router
{
    private array $routes = [];

    public function add(string $method, string $route, callable $handler): void
    {
        $this->routes[strtoupper($method)][$route] = $handler;
    }

    public function dispatch(string $uri): mixed
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

        $handler = $this->routes[$method][$uri] ?? null;

        if (is_callable($handler)) {
            return $handler();
        }

        return ['error' => 'Route not found', 'method' => $method, 'path' => $uri];
    }
}

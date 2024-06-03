<?php

declare(strict_types=1);

namespace AlexanderGladkov\Broker\Web\Router;

use AlexanderGladkov\Broker\Web\Request\Request;
use LogicException;

class Router
{
    private array $routes = [];

    public function register(array|string $requestMethods, string $route, callable|array $action): self
    {
        if (is_string($requestMethods)) {
            $requestMethods = [$requestMethods];
        }

        foreach ($requestMethods as $requestMethod) {
            $this->routes[$requestMethod][$route] = $action;
        }

        return $this;
    }

    public function get(string $route, callable|array $action): self
    {
        return $this->register('get', $route, $action);
    }

    public function post(string $route, callable|array $action): self
    {
        return $this->register('post', $route, $action);
    }

    /**
     * @throws RouteNotFoundException
     */
    public function resolve(string $requestUri, string $requestMethod): string
    {
        $requestMethod = strtolower($requestMethod);
        $route = explode('?', $requestUri)[0];
        $action = $this->routes[$requestMethod][$route] ?? null;
        if (!$action) {
            throw new RouteNotFoundException();
        }

        $request = new Request($requestMethod, $_GET, $_POST);
        if (is_callable($action)) {
            return call_user_func($action, $request);
        }

        if (is_array($action)) {
            [$class, $method] = $action;
            if (class_exists($class)) {
                $object = new $class();
                if (method_exists($object, $method)) {
                    return call_user_func([$object, $method], $request);
                }
            }
        }

        throw new LogicException();
    }
}

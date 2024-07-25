<?php

namespace App\Http;

use App\Http\Exceptions\NotFoundHttpException;

/**
 * Custom route solution.
 */
class Router
{
    /**
     * @var array The registered routes
     */
    private static array $routes = [];

    /**
     * Registers a GET route.
     *
     * @param string $path The route path
     * @param callable $handler The handler for the route
     */
    public static function get(string $path, callable $handler): void
    {
        static::addRoute('GET', $path, $handler);
    }

    /**
     * Registers a POST route.
     *
     * @param string $path The route path
     * @param callable $handler The handler for the route
     */
    public static function post(string $path, callable $handler): void
    {
        static::addRoute('POST', $path, $handler);
    }

    /**
     * Adds a route to the router.
     *
     * @param string $method The HTTP method
     * @param string $path The route path
     * @param callable $handler The handler for the route
     */
    private static function addRoute(string $method, string $path, callable $handler): void
    {
        static::$routes[$method][$path] = $handler;
    }

    /**
     * Dispatches the request to the appropriate route handler.
     *
     * @param string $method The HTTP method
     * @param string $path The route path
     * @param array $queryParams The query parameters
     * @param array $bodyParams The body parameters
     *
     * @throws NotFoundHttpException If the route is not found
     */
    public static function dispatch(string $method, string $path, array $queryParams = [], array $bodyParams = []): void
    {
        if (!isset(static::$routes[$method][$path])) {
            throw new NotFoundHttpException("Url $path does not exist.");
        }

        call_user_func(static::$routes[$method][$path], $queryParams, $bodyParams);
    }
}

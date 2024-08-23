<?php

namespace Core;

class Router
{
    private static array $routes = [
        '/' => [\Controllers\Start::class, 'index'],
        '/string' => [\Controllers\Start::class, 'post_string'],
    ];
    private static array $PARAMS;

    public static function getUrl()
    {
        $path = $_SERVER['REQUEST_URI'];
        $position = strpos($path, '?');

        return $position !== false ? substr($path, 0, $position) : $path;
    }

    public static function setParams()
    {
        self::$PARAMS = [
            'GET' => $_GET,
            'POST' => json_decode(file_get_contents('php://input'), true) ?? [],
        ];
    }
    public static function getParams(): array
    {
        return self::$PARAMS;
    }

    public static function start()
    {
        $callback = self::$routes[self::getUrl()] ?? false;

        if (is_array($callback)) {
            self::setParams();
            $class = new $callback[0]();
            $method = $callback[1];
            $class->$method();
            die;
        }

        self::renderPage404();
    }

    public static function renderPage404(): void
    {
        header("HTTP/1.0 404 Not Found");
        echo "<h1>404 Not Found</h1>";
        echo "The page that you have requested could not be found.";
        exit();
    }

    public static function showJson(array $array)
    {
        header('Content-Type: application/json');
        $array['hostname'] = $_SERVER['HOSTNAME'];
        $array['session'] = $_SESSION;
        exit(json_encode($array));
    }

    public static function buildSuccess(array $body = [])
    {
        return ['ok' => 1, 'content' => $body];
    }
    public static function buildError(string $error = 'default error', int $code = 400)
    {
        http_response_code($code);
        return ['ok' => 0, 'error' => $error];
    }
}
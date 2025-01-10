<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw10\Classes;

use Asyrovatkin\Hw10\Services\YoutubeStat\SeederYoutubeStat;
use Asyrovatkin\Hw10\Services\YoutubeStat\YoutubeStatistic;

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
                    echo 'youtube statistic!';
                },
                'summary' => function ($channelTitle) {
                    (new YoutubeStatistic())->getSummary($channelTitle);
                },
                'top' => function ($topNum) {
                    (new YoutubeStatistic())->getTop($topNum);
                },
                'seed' => function ($length) {
                    (new SeederYoutubeStat())->seed($length);
                }
            ]
        ];
    }
}
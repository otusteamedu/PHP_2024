<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw11\Classes;

use Asyrovatkin\Hw11\Builders\EventBuilder;
use Asyrovatkin\Hw11\Controllers\EventController;
use Asyrovatkin\Hw11\Helpers\InputFormatterToJson;
use Asyrovatkin\Hw11\Repositories\EventRepository;

class Router
{
    private array $routes;
    public Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
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
                'clear' => function() {
                    $this->getEventController()->clearStorage();
                },
                'search' => function() {
                    echo file_get_contents('./src/Views/search.html');
                }
            ],
            'post' => [
                'main' => function() {
                    $this->getEventController()->putEvent();
                },
                'search' => function() {
                    $this->getEventController()->getEventIdsByParamsWithMaxPriority();
                }
            ]
        ];
    }

    private function getEventController()
    {
        $eventRepository = new EventRepository();
        $inputFormatterToJson = new InputFormatterToJson();
        $eventBuilder = new EventBuilder();
        return new EventController($eventRepository, $inputFormatterToJson, $eventBuilder);
    }
}
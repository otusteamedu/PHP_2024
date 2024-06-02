<?php

declare(strict_types=1);

namespace AlexanderGladkov\Broker\Web\Application;

use AlexanderGladkov\Broker\Web\Router\Router;
use AlexanderGladkov\Broker\Web\Router\RouteNotFoundException;
use AlexanderGladkov\Broker\Web\Controller\MessageController;

class Application
{
    private Router $router;

    public function __construct()
    {
        $this->router = new Router();
        $this->router->register(['get', 'post'], '/', [MessageController::class, 'form']);
    }

    public function run():void
    {
        try {
            echo $this->router->resolve($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
        } catch (RouteNotFoundException $e) {
            http_response_code(404);
            echo $e->getMessage() . PHP_EOL;
        }
    }
}

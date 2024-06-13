<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Infrastructure\Web\Application;

use DI\Container;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Interfaces\RouteParserInterface;

class Application
{
    private App $app;

    public function __construct(Container $container)
    {
        $this->app = AppFactory::createFromContainer($container);
        (new RoutesInitialization($this->app))->perform();
        (new MiddlewareInitialization($this->app))->perform();
        $this->addRouteParserToContainer();
    }

    private function addRouteParserToContainer(): void
    {
        $container = $this->app->getContainer();
        $routeParser = $this->app->getRouteCollector()->getRouteParser();
        $container->set(RouteParserInterface::class, $routeParser);
    }

    public function run(): void
    {
        $this->app->run();
    }
}

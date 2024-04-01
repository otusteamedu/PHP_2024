<?php

namespace Pozys\OtusShop;

use DI\Container;
use Dotenv\Dotenv;
use Pozys\OtusShop\Services\ElasticService;
use Pozys\OtusShop\Services\IOProcessor;

class App
{
    private Container $container;

    public function __construct()
    {
        $this->bootstrap();
        $this->initIndex();
    }

    public function run(): void
    {
        $IOProcessor = $this->container->get(IOProcessor::class);
        $parsedData = $IOProcessor->parseInput();

        $router = $this->container->get(Router::class);
        $router->handle($parsedData);
    }

    private function initIndex(): void
    {
        $elasticService = $this->container->get(ElasticService::class);
        $elasticService->initIndex();
    }

    private function bootstrap(): void
    {
        $dotenv = Dotenv::createUnsafeImmutable(dirname(__DIR__));
        $dotenv->load();

        $this->container = new Container();
    }
}

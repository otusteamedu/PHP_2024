<?php

declare(strict_types=1);

namespace AlexanderPogorelov\ElasticSearch;

use AlexanderPogorelov\ElasticSearch\Response\ResponseInterface;

class App
{
    private Resolver $resolver;

    public function __construct(private readonly array $argv)
    {
        $this->resolver = new Resolver($this->argv);
    }

    public function run(): void
    {
        $controllerData = $this->resolver->run();
        $response = call_user_func_array($controllerData['callback'], $controllerData['arguments']);
        /** @var ResponseInterface $response */
        $response->showResponse();
    }
}

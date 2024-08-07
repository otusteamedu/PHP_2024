<?php

declare(strict_types=1);

namespace Viking311\Analytics\Application;

use Viking311\Analytics\Command\FlushCommand;
use Viking311\Analytics\Http\Request\Request;
use Viking311\Analytics\Http\Response\Response;
use Viking311\Analytics\Registry\Adapter\RedisAdapterFactory;

class Application
{
    private array $routes = [
        '/flush' => FlushCommand::class,
    ];
    public function run(): Response
    {
        $request = new Request();
        $response = new Response();

        $uri = rtrim($request->getUri());

        if (array_key_exists($uri, $this->routes)) {
            $cmd = new $this->routes[$uri]();
            $cmd->run($request, $response);
        } else {
            $response->setResultCode(404);
            $response->setContent("Page not found");
        }

        return $response;
    }
}


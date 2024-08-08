<?php

declare(strict_types=1);

namespace Viking311\Analytics\Application;

use Viking311\Analytics\Command\AddCommand;
use Viking311\Analytics\Command\CommandInterface;
use Viking311\Analytics\Command\FlushCommand;
use Viking311\Analytics\Command\SearchCommand;
use Viking311\Analytics\Http\Request\Request;
use Viking311\Analytics\Http\Response\Response;

class Application
{
    /**  @var array<string, CommandInterface>   */
    private array $routes = [
        '/flush' => FlushCommand::class,
        '/add' => AddCommand::class,
        '/search' => SearchCommand::class
    ];

    /**
     *
     * @return Response
     */
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

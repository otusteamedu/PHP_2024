<?php

declare(strict_types=1);

namespace Alogachev\Homework\Infrastructure\Routing;

use Alogachev\Homework\Application\UseCase\GenerateBankStatementUseCase;
use Alogachev\Homework\Application\UseCase\GetBankStatementUseCase;
use Alogachev\Homework\Infrastructure\Exception\RouteNotFoundException;
use Alogachev\Homework\Infrastructure\Mapper\GenerateBankStatementMapper;
use Alogachev\Homework\Infrastructure\Mapper\GetBankStatementMapper;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\Request;

class Router
{
    /**
     * @var Route[]
     */
    private array $routes;
    private RouteMatcher $matcher;

    /**
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function __construct(
        ContainerInterface $container
    ) {
        $this->routes = [
            new Route(
                '/bank/statement/{statementId}',
                'GET',
                $container->get(GetBankStatementUseCase::class),
                $container->get(GetBankStatementMapper::class),
                [
                    'statementId' => '\d+'
                ]
            ),
            new Route(
                '/bank/statement',
                'POST',
                $container->get(GenerateBankStatementUseCase::class),
                $container->get(GenerateBankStatementMapper::class),
            ),
        ];
        $this->matcher = new RouteMatcher();
    }

    public function getRouteAndParams(Request $request): array
    {
        $match = [];

        foreach ($this->routes as $route) {
            if (
                $this->matcher->matchRoute($request->getPathInfo(), $request->getMethod(), $route, $match)
            ) {
                return [$route, $match];
            }
        }

        throw new RouteNotFoundException();
    }
}

<?php

declare(strict_types=1);

namespace Alogachev\Homework;

use Alogachev\Homework\Application\UseCase\BankStatementFormUseCase;
use Alogachev\Homework\Application\UseCase\GenerateBankStatementUseCase;
use Alogachev\Homework\Infrastructure\Exception\RouteNotFoundException;
use Alogachev\Homework\Infrastructure\Render\HtmlRenderManager;
use Alogachev\Homework\Infrastructure\Routing\Route;
use DI\Container;
use Dotenv\Dotenv;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\Request;

use function DI\create;
use function DI\get;

final class App
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function run(): void
    {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();

        $request = $this->resolveRequest();
        $route = $this->resolveRoute($request);

        ($route->getHandler())();
    }

    private function resolveDI(): ContainerInterface
    {
        $templatesPath = $_ENV['HTML_TEMPLATES_PATH'] ?? '';

        return new Container([
            HtmlRenderManager::class => create()->constructor($templatesPath),
            BankStatementFormUseCase::class => create()->constructor(get(HtmlRenderManager::class)),
            GenerateBankStatementUseCase::class => create()->constructor(get(HtmlRenderManager::class)),
        ]);
    }

    public function resolveRequest(): Request
    {
        return Request::createFromGlobals();
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function resolveRoute(Request $request): Route
    {
        $container = $this->resolveDI();

        $routes = [
            new Route(
                '/bank/statement',
                'GET',
                $container->get(BankStatementFormUseCase::class),
            ),
            new Route(
                '/bank/statement/generate',
                'POST',
                $container->get(GenerateBankStatementUseCase::class),
            ),
        ];

        foreach ($routes as $route) {
            if (
                $route->getPath() === $request->getPathInfo()
                && $route->getMethod() === $request->getMethod()
            ) {
                return $route;
            }
        }

        throw new RouteNotFoundException();
    }
}

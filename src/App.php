<?php

declare(strict_types=1);

namespace Alogachev\Homework;

use Alogachev\Homework\Application\UseCase\BankStatementFormUseCase;
use Alogachev\Homework\Application\UseCase\GenerateBankStatementUseCase;
use Alogachev\Homework\Infrastructure\Command\GenerateBankStatementCommend;
use Alogachev\Homework\Infrastructure\Exception\RouteNotFoundException;
use Alogachev\Homework\Infrastructure\Mapper\GenerateBankStatementMapper;
use Alogachev\Homework\Infrastructure\Messaging\AsyncHandler\GenerateBankStatementHandler;
use Alogachev\Homework\Infrastructure\Messaging\RabbitMQ\Consumer\GenerateBankStatementConsumer;
use Alogachev\Homework\Infrastructure\Messaging\RabbitMQ\Producer\GenerateBankStatementProducer;
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
        // ToDo: Тут добавить получение аргументов из консоли, если есть флаг consumer то запускаем консюмер.
        $dotenv = Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();

        $request = $this->resolveRequest();
        $route = $this->resolveRoute($request);
        $mapper = $route->getParamsMapper();

        ($route->getHandler())(is_null($mapper) ? null : $mapper->map($request));
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function runConsumers(): void
    {
        $container = $this->resolveDI();
        $bankStatement = $container->get(GenerateBankStatementCommend::class);
        $bankStatement->execute();
    }

    private function resolveDI(): ContainerInterface
    {
        $templatesPath = $_ENV['HTML_TEMPLATES_PATH'] ?? '';
        $rabbitHost = $_ENV['RABBIT_HOST'] ?? '';
        $rabbitPort = $_ENV['RABBIT_PORT'] ?? '';
        $rabbitUser = $_ENV['RABBIT_USER'] ?? '';
        $rabbitPassword = $_ENV['RABBIT_PASSWORD'] ?? '';

        return new Container([
            GenerateBankStatementHandler::class => create(),
            GenerateBankStatementProducer::class => create()->constructor(
                $rabbitHost,
                (int)$rabbitPort,
                $rabbitUser,
                $rabbitPassword,
            ),
            GenerateBankStatementConsumer::class => create()->constructor(
                $rabbitHost,
                (int)$rabbitPort,
                $rabbitUser,
                $rabbitPassword,
                get(GenerateBankStatementHandler::class),
            ),
            GenerateBankStatementCommend::class => create()->constructor(
                get(GenerateBankStatementConsumer::class),
            ),
            HtmlRenderManager::class => create()->constructor($templatesPath),
            BankStatementFormUseCase::class => create()->constructor(get(HtmlRenderManager::class)),
            GenerateBankStatementUseCase::class => create()->constructor(
                get(HtmlRenderManager::class),
                get(GenerateBankStatementProducer::class)
            ),
            GenerateBankStatementMapper::class => create(),
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
                null,
            ),
            new Route(
                '/bank/statement/generate',
                'POST',
                $container->get(GenerateBankStatementUseCase::class),
                $container->get(GenerateBankStatementMapper::class),
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

<?php

declare(strict_types=1);

namespace Alogachev\Homework;

use Alogachev\Homework\Application\Command\CommandInterface;
use Alogachev\Homework\Application\UseCase\GetBankStatementUseCase;
use Alogachev\Homework\Application\UseCase\GenerateBankStatementUseCase;
use Alogachev\Homework\Application\UseCase\Response\JsonResponseInterface;
use Alogachev\Homework\Infrastructure\Command\GenerateBankStatementCommand;
use Alogachev\Homework\Infrastructure\Exception\CommandNotFoundException;
use Alogachev\Homework\Infrastructure\Exception\RouteNotFoundException;
use Alogachev\Homework\Infrastructure\Http\Response\ErrorResponse;
use Alogachev\Homework\Infrastructure\Mapper\GenerateBankStatementMapper;
use Alogachev\Homework\Infrastructure\Mapper\GetBankStatementMapper;
use Alogachev\Homework\Infrastructure\Messaging\AsyncHandler\GenerateBankStatementHandler;
use Alogachev\Homework\Infrastructure\Messaging\RabbitMQ\Consumer\GenerateBankStatementConsumer;
use Alogachev\Homework\Infrastructure\Messaging\RabbitMQ\Producer\GenerateBankStatementProducer;
use Alogachev\Homework\Infrastructure\Messaging\RabbitMQ\RabbitManager;
use Alogachev\Homework\Infrastructure\Render\HtmlRenderManager;
use Alogachev\Homework\Infrastructure\Repository\PDOBankStatementRepository;
use Alogachev\Homework\Infrastructure\Routing\Route;
use Alogachev\Homework\Infrastructure\Routing\Router;
use DI\Container;
use Dotenv\Dotenv;
use Exception;
use PDO;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
        $this->loadEnv();

        $request = $this->resolveRequest();
        $route = $this->resolveRoute($request);
        $mapper = $route->getParamsMapper();

        try {
            $response = ($route->getHandler())(is_null($mapper) ? null : $mapper->map($request));
            $this->resolveResponse($response, Response::HTTP_OK);
        } catch (Exception $exception) {
            $this->resolveResponse(new ErrorResponse($exception->getMessage()), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function runConsole(): void
    {
        $this->loadEnv();
        [$commandName] = $this->resolveConsole();

        try {
            $container = $this->resolveDI();
            $command = $container->get($commandName);
            if ($command instanceof CommandInterface) {
                $command->execute();
            }
        } catch (NotFoundExceptionInterface $exception) {
            throw new CommandNotFoundException($commandName, $exception);
        }
    }

    public function loadEnv(): void
    {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();
    }

    private function resolveDI(): ContainerInterface
    {
        $templatesPath = $_ENV['HTML_TEMPLATES_PATH'] ?? '';
        $rabbitHost = $_ENV['RABBIT_HOST'] ?? '';
        $rabbitPort = $_ENV['RABBIT_PORT'] ?? '';
        $rabbitUser = $_ENV['RABBIT_USER'] ?? '';
        $rabbitPassword = $_ENV['RABBIT_PASSWORD'] ?? '';

        // postgres data
        $host = $_ENV['POSTGRES_DB_HOST'] ?? null;
        $db   = $_ENV['POSTGRES_DB_NAME'] ?? null;
        $dbPort = $_ENV['POSTGRES_PORT'] ?? null;
        $user = $_ENV['POSTGRES_USER'] ?? null;
        $pass = $_ENV['POSTGRES_PASSWORD'] ?? null;
        $dsn = "pgsql:host=$host;port=$dbPort;dbname=$db;user=$user;password=$pass";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        $pdo = new PDO($dsn, $user, $pass, $options);

        return new Container([
            PDO::class => $pdo,
            RabbitManager::class => create()->constructor(
                $rabbitHost,
                (int)$rabbitPort,
                $rabbitUser,
                $rabbitPassword,
            ),
            PDOBankStatementRepository::class => create()->constructor(
                get(PDO::class)
            ),
            GenerateBankStatementHandler::class => create()->constructor(
                get(PDOBankStatementRepository::class),
            ),
            GenerateBankStatementProducer::class => create()->constructor(
                get(RabbitManager::class),
            ),
            GenerateBankStatementConsumer::class => create()->constructor(
                get(RabbitManager::class),
                get(GenerateBankStatementHandler::class),
            ),
            GenerateBankStatementCommand::class => create()->constructor(
                get(GenerateBankStatementConsumer::class),
            ),
            HtmlRenderManager::class => create()->constructor($templatesPath),
            GetBankStatementUseCase::class => create()->constructor(
                get(PDOBankStatementRepository::class)
            ),
            GenerateBankStatementUseCase::class => create()->constructor(
                get(GenerateBankStatementProducer::class),
                get(PDOBankStatementRepository::class),
            ),
            GenerateBankStatementMapper::class => create(),
            GetBankStatementMapper::class => create(),
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

        return (new Router($container))->getRouteByRequest($request);
    }

    private function resolveConsole(): array
    {
        $args = $_SERVER['argv'];
        $resolved = [];

        foreach ($args as $key => $arg) {
            if ($key > 0) {
                $resolved[] = $arg;
            }
        }

        return $resolved;
    }

    private function resolveResponse(JsonResponseInterface $content, int $statusCode): void
    {
        $response = new Response();
        $response
            ->setStatusCode($statusCode)
            ->setContent(json_encode($content->toArray()))
            ->headers->set('Content-Type', 'application/json')
        ;

        $response->send();
    }
}

<?php

declare(strict_types=1);

use App\Application\UseCase\ApiRequest\ProcessApiRequestUseCase;
use App\Infrastructure\Async\RabbitMQ\ApiRequestProcessorSubscriber;
use App\Infrastructure\Persistence\Repository\DatabaseApiRequestRepository;
use DI\ContainerBuilder;
use Dotenv\Dotenv;

use function DI\{autowire, get};

require_once dirname(__DIR__) . '/vendor/autoload.php';

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions([
    ApiRequestProcessorSubscriber::class => autowire()
        ->constructor(handler: get(ProcessApiRequestUseCase::class)),
]);

$settings = require __DIR__ . '/../app/settings.php';
$settings($containerBuilder);

$dependencies = require __DIR__ . '/../app/dependencies.php';
$dependencies($containerBuilder);

$repositories = require __DIR__ . '/../app/repositories.php';
$repositories($containerBuilder);

$container = $containerBuilder->build();

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$queue = $container->get(ApiRequestProcessorSubscriber::class);

$queue->handle();

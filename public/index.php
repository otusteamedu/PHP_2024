<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Dotenv\Dotenv;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Pozys\BankStatement\Application;
use Pozys\BankStatement\Application\UseCase\GetBankStatementAsyncUseCase;
use Pozys\BankStatement\Infrastructure\Async\RabbitMQ\BankStatementRequestPublisher;
use Pozys\BankStatement\Infrastructure\Http\ServerRequestCreatorFactory;

use function DI\get;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$builder = new ContainerBuilder();
$builder->addDefinitions([
    GetBankStatementAsyncUseCase::class => DI\autowire()
        ->constructor(get(BankStatementRequestPublisher::class)),
]);

$container = $builder->build();

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$serverRequestCreator = $container->get(ServerRequestCreatorFactory::class);
$request = $serverRequestCreator->createServerRequestFromGlobals();

$app = $container->get(Application::class);
$response = $app->handle($request);

($container->get(SapiEmitter::class))->emit($response);

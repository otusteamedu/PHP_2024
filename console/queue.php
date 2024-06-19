<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Dotenv\Dotenv;
use Pozys\BankStatement\Application\UseCase\ProcessBankStatementRequestUseCase;
use Pozys\BankStatement\Infrastructure\Async\RabbitMQ\BankStatementRequestSubscriber;
use Pozys\BankStatement\Infrastructure\Messenger\NativeMailer;
use Pozys\BankStatement\Infrastructure\Persistence\BankStatementRepository;

use function DI\get;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$builder = new ContainerBuilder();
$builder->addDefinitions([
    ProcessBankStatementRequestUseCase::class => DI\autowire()
        ->constructor(get(BankStatementRepository::class), get(NativeMailer::class)),
    BankStatementRequestSubscriber::class => DI\autowire()
        ->constructor(handler: get(ProcessBankStatementRequestUseCase::class)),
]);

$container = $builder->build();

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$queue = $container->get(BankStatementRequestSubscriber::class);

$queue->handle();

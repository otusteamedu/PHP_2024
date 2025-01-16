<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\Banking\Console\Command\StartConsumerCommand;
use App\Banking\Http\Controller\Api\Statements\GenerateStatementAsyncController;
use App\Banking\Http\Controller\Api\Statements\GenerateStatementController;
use App\Banking\Notification\NullNotificationTransport;
use App\Banking\Queue\ConnectionProvider;
use App\Banking\Queue\Consumer\GenerateStatementConsumer;
use App\Banking\Queue\Publisher\GenerateStatementPublisher;
use App\Banking\StatementGenerator\NotifiableStatementGenerator;
use App\Banking\StatementGenerator\NullStatementGenerator;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Symfony\Component\DependencyInjection\ContainerBuilder;

$container = new ContainerBuilder();

# Services

$container->set(
    'queue.connection',
    new AMQPStreamConnection(
        host: $_ENV['RABBITMQ_HOST'] ?? 'localhost',
        port: $_ENV['RABBITMQ_PORT'] ?? 5672,
        user: $_ENV['RABBITMQ_DEFAULT_USER'] ?? 'guest',
        password: $_ENV['RABBITMQ_DEFAULT_PASSWORD'] ?? 'guest',
    )
);

$container->register(ConnectionProvider::class, ConnectionProvider::class)
    ->setPublic(true)
    ->setAutowired(true)
    ->setAutoconfigured(true)
    ->setArgument('$connection', $container->get('queue.connection'))
;

$container->register(NullNotificationTransport::class, NullNotificationTransport::class);

$container->register(NullStatementGenerator::class, NullStatementGenerator::class);

$container->register(NotifiableStatementGenerator::class, NotifiableStatementGenerator::class)
    ->setArgument('$statementGenerator', $container->get(NullStatementGenerator::class))
    ->setArgument('$notificationTransport', $container->get(NullNotificationTransport::class))
;

$container->register(GenerateStatementPublisher::class, GenerateStatementPublisher::class)
    ->setArgument('$connectionProvider', $container->get(ConnectionProvider::class))
;

$container->register(GenerateStatementConsumer::class, GenerateStatementConsumer::class)
    ->setArgument('$statementGenerator', $container->get(NotifiableStatementGenerator::class))
;

$container->setAlias('queue.consumer.generate_statement', GenerateStatementConsumer::class);

# Console Commands

$container->register(StartConsumerCommand::class, StartConsumerCommand::class)
    ->setArgument('$container', $container)
    ->setArgument('$connectionProvider', $container->get(ConnectionProvider::class))
;

# Controllers

$container->register(GenerateStatementAsyncController::class, GenerateStatementAsyncController::class)
    ->setArgument('$publisher', $container->get(GenerateStatementPublisher::class))
;

$container->register(GenerateStatementController::class, GenerateStatementController::class)
    ->setArgument('$statementGenerator', $container->get(NullStatementGenerator::class))
;

return $container;

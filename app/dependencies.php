<?php

declare(strict_types=1);

use App\Application\Settings\SettingsInterface;
use App\Application\UseCase\ApiRequest\GetApiRequestStatusUseCase;
use App\Application\UseCase\ApiRequest\RegisterApiRequestUseCase;
use App\Infrastructure\Async\RabbitMQ\RegisterApiRequestPublisher;
use App\Infrastructure\Persistence\Repository\DatabaseApiRequestRepository;
use DI\ContainerBuilder;
use Illuminate\Database\Capsule\Manager;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

use function DI\autowire;
use function DI\get;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);

            $loggerSettings = $settings->get('logger');
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },
        Manager::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);
            $capsule = new Manager();
            $capsule->addConnection($settings->get('db'));
            $capsule->setAsGlobal();

            return $capsule;
        },
        RegisterApiRequestUseCase::class => autowire()
            ->constructor(get(RegisterApiRequestPublisher::class), get(DatabaseApiRequestRepository::class)),
        GetApiRequestStatusUseCase::class => autowire()
            ->constructor(get(DatabaseApiRequestRepository::class)),
    ]);
};

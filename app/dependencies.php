<?php

declare(strict_types=1);

use App\Application\Settings\SettingsInterface;
use App\Infrastructure\Config;
use App\Infrastructure\Consumer;
use App\Infrastructure\CustomerTask\CustomerTaskDataMapper;
use App\Infrastructure\DbClient;
use App\Infrastructure\RabbitClient;
use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

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
        DbClient::class => function (ContainerInterface $c) {
            $config = $c->get(Config::class);

            return new DbClient($config);
        },
        RabbitClient::class => function (ContainerInterface $c) {
            $config = $c->get(Config::class);
            $queueName = 'customer-tasks';
            return new RabbitClient($config, $queueName);
        },
        CustomerTaskDataMapper::class => function (ContainerInterface $c) {
            $dbClient = $c->get(DbClient::class);

            return new CustomerTaskDataMapper($dbClient->getDbConnection());
        },
        Consumer::class => function (ContainerInterface $c) {
            $rabbitClient = $c->get(RabbitClient::class);
            $customerTaskDataMapper = $c->get(CustomerTaskDataMapper::class);

            return new Consumer($rabbitClient, $customerTaskDataMapper);
        }
    ]);
};

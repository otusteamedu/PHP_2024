<?php

declare(strict_types=1);

use App\Application\Settings\SettingsInterface;
use App\Domain\Exporter\ExporterInterface;
use App\Infrastructure\Exporter\BaseExporter;
use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Log\LoggerInterface;
use Slim\Psr7\Factory\StreamFactory;

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
        StreamFactoryInterface::class => function (ContainerInterface $container) {
            return new StreamFactory();
        },
        ExporterInterface::class => function (ContainerInterface $container) {
            return new BaseExporter();
        }
    ]);

};

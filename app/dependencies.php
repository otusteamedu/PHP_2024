<?php

declare(strict_types=1);

use App\Application\Settings\SettingsInterface;
use App\Domain\Event\EventManager;
use App\Domain\Event\OrderStatusChanged;
use App\Domain\Interface\PublisherInterface;
use App\Domain\Listener\OrderStatusChangedListener;
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
        PublisherInterface::class => function () {
            $eventManager = new EventManager();
            $eventManager->subscribe(OrderStatusChanged::class, OrderStatusChangedListener::class);

            return $eventManager;
        }
    ]);
};

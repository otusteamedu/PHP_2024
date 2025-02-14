<?php

declare(strict_types=1);

use App\Application\Factory\TaskFactory;
use App\Application\Messaging\MessageSenderInterface;
use App\Domain\Factory\TaskFactoryInterface;
use App\Infrastructure\Messaging\RabbitMqMessageSender;
use DI\ContainerBuilder;
use Psr\Http\Message\ResponseFactoryInterface;
use Slim\Psr7\Factory\ResponseFactory;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        ResponseFactoryInterface::class => function () {
            return new ResponseFactory();
        },
        TaskFactoryInterface::class => function () {
            return new TaskFactory();
        },
        MessageSenderInterface::class => function () {
            // TODO env
            return new RabbitMqMessageSender(
                'rabbitmq',
                5672,
                'guest',
                'guest'
            );
        }
    ]);
};

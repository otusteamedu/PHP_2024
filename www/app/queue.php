<?php

declare(strict_types=1);

use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;
use PhpAmqpLib\Connection\AMQPStreamConnection;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        \App\Application\Queue\QueueInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);
            $rabbit = $settings->get('rabbit');

            return new \App\Infrastructure\Queue\RabbitQueue(
                $rabbit['queue'],
                new AMQPStreamConnection($rabbit['host'], $rabbit['port'], $rabbit['user'], $rabbit['pass'])
            );
        }
    ]);
};

<?php

declare(strict_types=1);

namespace App\Infrastructure\Factory\Queue\RabbitMQ;

use App\Infrastructure\Service\Queue\RabbitMQ\ConnectionSettings;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ConnectionSettingsFactory
{
    public function createDefault(ContainerInterface $container): ConnectionSettings
    {
        return new ConnectionSettings(
            $container->getParameter('app.rabbit_mq.host'),
            (int) $container->getParameter('app.rabbit_mq.port'),
            $container->getParameter('app.rabbit_mq.username'),
            $container->getParameter('app.rabbit_mq.password')
        );
    }
}

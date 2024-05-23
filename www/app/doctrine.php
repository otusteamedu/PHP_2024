<?php

declare(strict_types=1);

use App\Application\Settings\SettingsInterface;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Psr\Container\ContainerInterface;

return function (\DI\ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        \Doctrine\ORM\EntityManager::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);

            $config = ORMSetup::createAttributeMetadataConfiguration(
                paths: [
                    __DIR__ . "/../src/Infrastructure/Entity"
                ],
                isDevMode: true,
            );

            $connection = DriverManager::getConnection($settings->get('db'), $config);

            $em = new EntityManager($connection, $config);

            return $em;
        },
    ]);
};
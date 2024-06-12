<?php

declare(strict_types=1);

use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Psr\Container\ContainerInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        \Doctrine\ORM\EntityManagerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);

            $config = ORMSetup::createAttributeMetadataConfiguration(
                paths: [
                    __DIR__ . "/../src/Domain"
                ],
                isDevMode: true,
            );

            $connection = DriverManager::getConnection($settings->get('db'), $config);

            $em = new EntityManager($connection, $config);

            return $em;
        },
    ]);
};

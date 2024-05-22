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

            $config = ORMSetup::createConfiguration(
                isDevMode: true,
            );
            $driver = new \Doctrine\Persistence\Mapping\Driver\StaticPHPDriver(__DIR__ . "/../src/Infrastructure/Entity");
            $config->setMetadataDriverImpl($driver);

            $connection = DriverManager::getConnection($settings->get('db'), $config);

            $em = new EntityManager($connection, $config);

//            \Doctrine\ORM\Tools\Console\ConsoleRunner::run(
//                new \Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider($em),
//                []
//            );

            return $em;
        },
    ]);
};
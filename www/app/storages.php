<?php

declare(strict_types=1);

use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        \App\Domain\Image\ImageStorageInterface::class => function (\Psr\Container\ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);

            return new \App\Infrastructure\Storage\ImageStorage(
                $c->get(\Doctrine\ORM\EntityManagerInterface::class),
                $c->get(\App\Application\Queue\QueueInterface::class),
            );
        }
    ]);
};

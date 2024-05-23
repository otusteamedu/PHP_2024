<?php

declare(strict_types=1);

use App\Domain\User\UserRepository;
use App\Domain\News\NewsRepository;
use App\Domain\Category\CategoryRepository;
use App\Infrastructure\Entity as Entity;
use DI\ContainerBuilder;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        UserRepository::class => function (ContainerInterface $container) {
            $em = $container->get(EntityManager::class);

            $cmf = $em->getMetadataFactory();
            $class = $cmf->getMetadataFor(Entity\UserEntity::class);

            return new \App\Infrastructure\Repository\UserPGRepository($em, $class);
        },
        NewsRepository::class => function (ContainerInterface $container) {
            $em = $container->get(EntityManager::class);

            $cmf = $em->getMetadataFactory();
            $class = $cmf->getMetadataFor(Entity\NewsEntity::class);

            return new \App\Infrastructure\Repository\NewsPGRepository($em, $class);
        },
        CategoryRepository::class => function (ContainerInterface $container) {
            $em = $container->get(EntityManager::class);

            $cmf = $em->getMetadataFactory();
            $class = $cmf->getMetadataFor(Entity\CategoryEntity::class);

            return new \App\Infrastructure\Repository\CategoryPGRepository($em, $class);
        },
    ]);
};

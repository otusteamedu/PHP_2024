<?php

declare(strict_types=1);

require_once __DIR__ . '/../constants.php';

use AlexanderGladkov\CleanArchitecture\Domain;
use AlexanderGladkov\CleanArchitecture\Application;
use AlexanderGladkov\CleanArchitecture\Infrastructure;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Monolog\Level;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use Slim\Views\Twig;

return [
    'settings' => require CONFIG_DIR . '/settings.php',
    'host' => function(ContainerInterface $container) {
        return $container->get('settings')['general']['host'];
    },
    ValidatorInterface::class => function() {
        $builder = new Symfony\Component\Validator\ValidatorBuilder();
        $builder->enableAttributeMapping();
        return $builder->getValidator();
    },
    LoggerInterface::class => function(ContainerInterface $container) {
        $loggerSettings = $container->get('settings')['logger'];
        $logger = new Monolog\Logger('app');
        $logger->pushHandler(new StreamHandler($loggerSettings['log_path'], Level::Debug));
        $logger->pushHandler(new FirePHPHandler());
        return $logger;
    },
    EntityManager::class => function(ContainerInterface $container) {
        $doctrineSettings =  $container->get('settings')['doctrine'];
        $isDevelopmentMode = $doctrineSettings['development_mode'];

        if ($isDevelopmentMode) {
            $cache = new ArrayAdapter();
        } else {
            $cache = new FilesystemAdapter(directory: $doctrineSettings['cache_directory']);
        }

        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: $doctrineSettings['metadata_directories'],
            isDevMode: $isDevelopmentMode,
            cache: $cache
        );

        $connection = DriverManager::getConnection($doctrineSettings['connection']);
        return new EntityManager($connection, $config);
    },
    Twig::class => function(ContainerInterface $container) {
        $twigSettings = $container->get('settings')['twig'];
        return Twig::create($twigSettings['templates_directory'], [
            'cache' => $twigSettings['cache_directory'],
            'auto_reload' => $twigSettings['auto_reload'],
        ]);
    },

    Domain\Service\ValidationServiceInterface::class =>
        DI\autowire(Infrastructure\Service\Validation\ValidationService::class),
    Domain\Repository\NewsRepositoryInterface::class =>
        DI\autowire(Infrastructure\Repository\NewsRepository::class),
    Application\Service\ParseUrl\ParseUrlServiceInterface::class =>
        DI\autowire(Infrastructure\Service\ParseUrl\ParseUrlService::class),
    Application\Service\Report\NewsReportServiceInterface::class =>
        DI\autowire(Infrastructure\Service\Report\NewsReportService::class)
            ->constructorParameter('reportsDirectory', APP_ROOT_DIR . '/tmp/report/news'),
    Application\Service\GenerateLink\GenerateLinkServiceInterface::class =>
        DI\autowire(Infrastructure\Service\GenerateLink\GenerateLinkService::class)
            ->constructorParameter('host', DI\get('host')),
];
